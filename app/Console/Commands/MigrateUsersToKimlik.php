<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateUsersToKimlik extends Command
{
    protected $signature = 'users:migrate-to-kimlik
                            {--dry-run : Run without making changes}
                            {--limit= : Limit number of users to process}';
    protected $description = 'Migrate task.az users to Kimlik.az';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $limit = $this->option('limit');

        if ($dryRun) {
            $this->info('DRY RUN MODE - No changes will be made');
        }

        $this->info('Starting user migration to Kimlik.az...');

        // Check kimlik database connection
        try {
            DB::connection('kimlik')->getPdo();
            $this->info('Kimlik.az database connection OK');
        } catch (\Exception $e) {
            $this->error('Cannot connect to Kimlik.az database: ' . $e->getMessage());
            $this->error('Please check KIMLIK_DB_* environment variables');
            return Command::FAILURE;
        }

        // Get task.az users without wallet_id
        $query = User::whereNull('wallet_id');

        if ($limit) {
            $query->limit((int) $limit);
        }

        $taskUsers = $query->get();

        if ($taskUsers->isEmpty()) {
            $this->info('No users to migrate (all users already have wallet_id)');
            return Command::SUCCESS;
        }

        $this->info("Found {$taskUsers->count()} users to process");

        $stats = [
            'mapped_by_email' => 0,
            'mapped_by_phone' => 0,
            'created_new' => 0,
            'skipped' => 0,
            'errors' => 0,
        ];

        $this->output->progressStart($taskUsers->count());

        foreach ($taskUsers as $taskUser) {
            try {
                $result = $this->processUser($taskUser, $dryRun);
                $stats[$result]++;
            } catch (\Exception $e) {
                $stats['errors']++;
                Log::error('User migration error', [
                    'user_id' => $taskUser->id,
                    'error' => $e->getMessage(),
                ]);
                $this->newLine();
                $this->error("Error processing user {$taskUser->id}: {$e->getMessage()}");
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();

        $this->newLine();
        $this->info('Migration completed!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Mapped by email', $stats['mapped_by_email']],
                ['Mapped by phone', $stats['mapped_by_phone']],
                ['Created new', $stats['created_new']],
                ['Skipped (no email/phone)', $stats['skipped']],
                ['Errors', $stats['errors']],
            ]
        );

        return Command::SUCCESS;
    }

    private function processUser(User $taskUser, bool $dryRun): string
    {
        // First try to find by email
        if (!empty($taskUser->email)) {
            $kimlikUser = DB::connection('kimlik')
                ->table('users')
                ->where('email', $taskUser->email)
                ->first();

            if ($kimlikUser) {
                if (!$dryRun) {
                    $taskUser->update(['wallet_id' => $kimlikUser->id]);
                }
                return 'mapped_by_email';
            }
        }

        // Then try to find by phone
        if (!empty($taskUser->phone)) {
            $normalizedPhone = $this->normalizePhone($taskUser->phone);

            $kimlikUser = DB::connection('kimlik')
                ->table('users')
                ->where('phone', $normalizedPhone)
                ->first();

            if ($kimlikUser) {
                if (!$dryRun) {
                    $taskUser->update(['wallet_id' => $kimlikUser->id]);
                }
                return 'mapped_by_phone';
            }
        }

        // If no match found and user has email or phone, create new kimlik user
        if (!empty($taskUser->email) || !empty($taskUser->phone)) {
            if (!$dryRun) {
                $newKimlikId = DB::connection('kimlik')
                    ->table('users')
                    ->insertGetId([
                        'name' => $taskUser->name,
                        'email' => $taskUser->email,
                        'phone' => !empty($taskUser->phone) ? $this->normalizePhone($taskUser->phone) : null,
                        'avatar' => $taskUser->avatar,
                        'provider' => 'taskaz_migration',
                        'email_verified_at' => $taskUser->email_verified_at,
                        'phone_verified_at' => $taskUser->phone_verified_at,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                $taskUser->update(['wallet_id' => $newKimlikId]);
            }
            return 'created_new';
        }

        // No email and no phone - skip
        return 'skipped';
    }

    private function normalizePhone(string $phone): string
    {
        // Remove all non-digits
        $phone = preg_replace('/\D/', '', $phone);

        // Ensure it starts with 994
        if (!str_starts_with($phone, '994')) {
            $phone = '994' . ltrim($phone, '0');
        }

        return $phone;
    }
}
