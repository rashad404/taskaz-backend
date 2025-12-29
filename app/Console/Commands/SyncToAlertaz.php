<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncToAlertaz extends Command
{
    protected $signature = 'alertaz:sync {--schema-only : Only register schema without syncing contacts}';
    protected $description = 'Sync users to Alert.az SMS platform';

    public function handle(): int
    {
        $apiKey = config('services.alertaz.client_api_key');
        $baseUrl = config('services.alertaz.url');

        if (empty($apiKey)) {
            $this->error('ALERTAZ_CLIENT_API_KEY is not configured in .env');
            return Command::FAILURE;
        }

        $this->info('Starting Alert.az sync...');

        // Step 1: Register schema
        $this->info('Registering schema...');
        $schemaResponse = $this->registerSchema($baseUrl, $apiKey);

        if (!$schemaResponse) {
            $this->error('Failed to register schema');
            return Command::FAILURE;
        }

        $this->info('Schema registered successfully');

        if ($this->option('schema-only')) {
            $this->info('Schema-only mode, skipping contact sync');
            return Command::SUCCESS;
        }

        // Step 2: Sync contacts
        $this->info('Syncing contacts...');
        $syncResult = $this->syncContacts($baseUrl, $apiKey);

        if (!$syncResult) {
            $this->error('Failed to sync contacts');
            return Command::FAILURE;
        }

        $this->info("Sync completed! {$syncResult['synced']} contacts synced.");

        return Command::SUCCESS;
    }

    private function registerSchema(string $baseUrl, string $apiKey): ?array
    {
        $schema = [
            ['key' => 'name', 'type' => 'string', 'label' => 'Ad', 'required' => false],
            ['key' => 'registration_date', 'type' => 'date', 'label' => 'Qeydiyyat tarixi', 'required' => false],
            ['key' => 'is_professional', 'type' => 'boolean', 'label' => 'Professional', 'required' => false],
            ['key' => 'professional_status', 'type' => 'enum', 'label' => 'Professional status', 'options' => ['pending', 'approved', 'rejected'], 'required' => false],
            ['key' => 'type', 'type' => 'enum', 'label' => 'İstifadəçi tipi', 'options' => ['client', 'professional', 'both'], 'required' => false],
            ['key' => 'tasks_count', 'type' => 'integer', 'label' => 'Tapşırıqlar sayı', 'required' => false],
            ['key' => 'applications_count', 'type' => 'integer', 'label' => 'Müraciətlər sayı', 'required' => false],
            ['key' => 'city', 'type' => 'string', 'label' => 'Şəhər', 'required' => false],
        ];

        try {
            $response = Http::withToken($apiKey)
                ->post("{$baseUrl}/clients/schema", [
                    'attributes' => $schema,
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            $this->error('Schema registration failed: ' . $response->body());
            Log::error('Alert.az schema registration failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            $this->error('Schema registration error: ' . $e->getMessage());
            Log::error('Alert.az schema registration error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function syncContacts(string $baseUrl, string $apiKey): ?array
    {
        $users = User::whereNotNull('phone')
            ->where('phone', '!=', '')
            ->with(['city', 'postedTasks', 'applications'])
            ->get();

        if ($users->isEmpty()) {
            $this->warn('No users with phone numbers found');
            return ['synced' => 0];
        }

        $contacts = $users->map(function ($user) {
            return [
                'phone' => $this->formatPhone($user->phone),
                'attributes' => [
                    'name' => $user->name,
                    'registration_date' => $user->created_at->format('Y-m-d'),
                    'is_professional' => $user->isProfessional(),
                    'professional_status' => $user->professional_status,
                    'type' => $user->type,
                    'tasks_count' => $user->postedTasks->count(),
                    'applications_count' => $user->applications->count(),
                    'city' => $user->city?->name ?? null,
                ],
            ];
        })->toArray();

        try {
            $response = Http::withToken($apiKey)
                ->post("{$baseUrl}/contacts/sync/bulk", [
                    'contacts' => $contacts,
                ]);

            if ($response->successful()) {
                return ['synced' => count($contacts)];
            }

            $this->error('Contact sync failed: ' . $response->body());
            Log::error('Alert.az contact sync failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            $this->error('Contact sync error: ' . $e->getMessage());
            Log::error('Alert.az contact sync error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private function formatPhone(string $phone): string
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
