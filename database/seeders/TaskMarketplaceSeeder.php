<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use App\Models\Application;
use App\Models\Contract;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TaskMarketplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create professionals
        $professionals = [];
        $professionalData = [
            ['name' => 'Əli Məmmədov', 'email' => 'ali@example.com', 'location' => 'Bakı', 'bio' => '5+ il təcrübəyə malik veb proqramçı. Laravel və React üzrə mütəxəssis.'],
            ['name' => 'Leyla Həsənova', 'email' => 'leyla@example.com', 'location' => 'Bakı', 'bio' => 'Peşəkar UI/UX dizayner. Müasir veb tətbiqlər üzrə ixtisaslaşıb.'],
            ['name' => 'Ramil Quliyev', 'email' => 'ramil@example.com', 'location' => 'Gəncə', 'bio' => 'Mobil tətbiq tərtibatçısı. React Native və Flutter üzrə ekspert.'],
            ['name' => 'Səbinə Əliyeva', 'email' => 'sabina@example.com', 'location' => 'Sumqayıt', 'bio' => 'Kontent yazıçısı və tərcüməçi (AZ/EN/RU). Kreativ və professional yanaşma.'],
            ['name' => 'Tural Bayramov', 'email' => 'tural@example.com', 'location' => 'Bakı', 'bio' => 'Rəqəmsal marketinq mütəxəssisi. Nəticə yönümlü strateqiyalar.'],
            ['name' => 'Günay Məhərrəmova', 'email' => 'gunay@example.com', 'location' => 'Bakı', 'bio' => 'Qrafik dizayner və brend identifikasiyası eksperti. Yaradıcı həllər.'],
        ];

        foreach ($professionalData as $data) {
            $professionals[] = User::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'type' => 'professional',
                'location' => $data['location'],
                'bio' => $data['bio'],
                'status' => 'active',
                'email_verified_at' => now(),
                // Professional status fields
                'professional_status' => 'approved',
                'professional_application_date' => now()->subDays(rand(30, 60)),
                'professional_approved_at' => now()->subDays(rand(1, 29)),
                'hourly_rate' => rand(15, 50),
                'skills' => ['Laravel', 'React', 'JavaScript', 'PHP'],
            ]);
        }

        // Create clients
        $clients = [];
        $clientData = [
            ['name' => 'Orxan İbrahimov', 'email' => 'orxan@example.com', 'location' => 'Bakı'],
            ['name' => 'Nigar Mustafayeva', 'email' => 'nigar@example.com', 'location' => 'Bakı'],
            ['name' => 'Elvin Hüseynov', 'email' => 'elvin@example.com', 'location' => 'Gəncə'],
        ];

        foreach ($clientData as $data) {
            $clients[] = User::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'type' => 'client',
                'location' => $data['location'],
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        // Get categories
        $categories = Category::whereNull('parent_id')->get();

        // Create tasks
        $tasks = [];
        $taskData = [
            [
                'title' => 'E-ticarət Veb Saytının Hazırlanması',
                'description' => 'Ödəniş inteqrasiyası, məhsul kataloqu və admin paneli olan tam funksional e-ticarət saytı lazımdır. Mobil responsive və SEO optimallaşdırılmış olmalıdır. Laravel və ya React ilə hazırlanması üstünlük təşkil edir.',
                'budget_type' => 'fixed',
                'budget_amount' => 5000,
                'category' => 'İT və Proqramlaşdırma',
                'is_remote' => true,
                'status' => 'open',
            ],
            [
                'title' => 'Yemək Çatdırılması üçün Mobil Tətbiq',
                'description' => 'Bolt Food kimi yemək çatdırılması tətbiqi hazırlamaq üçün təcrübəli mobil proqramçı axtarıram. iOS və Android versiyaları lazımdır. Real-time tracking və push bildirişlər əlavə olunmalıdır.',
                'budget_type' => 'fixed',
                'budget_amount' => 8000,
                'category' => 'İT və Proqramlaşdırma',
                'is_remote' => true,
                'status' => 'open',
            ],
            [
                'title' => 'Loqo və Brend İdentifikasiyası Dizaynı',
                'description' => 'Startup şirkət üçün peşəkar loqo dizaynı və tam brend identifikasiya paketi lazımdır. Vizit kartları, başlıq kağızları və sosial media şablonları daxildir. Müasir və sadə dizayn üstünlük təşkil edir.',
                'budget_type' => 'fixed',
                'budget_amount' => 800,
                'category' => 'Reklam və Dizayn',
                'location' => 'Bakı',
                'is_remote' => false,
                'status' => 'open',
            ],
            [
                'title' => 'Texnologiya Bloqu üçün Məqalələr',
                'description' => 'Texnologiya trendləri, süni intellekt və proqram təminatı haqqında 10 yüksək keyfiyyətli məqalə lazımdır. Hər məqalə 1500+ söz olmalı və SEO optimallaşdırılmalıdır. Azərbaycan dilində təmiz və professional yazı tələb olunur.',
                'budget_type' => 'fixed',
                'budget_amount' => 600,
                'category' => 'Yazı və Tərcümə',
                'is_remote' => true,
                'status' => 'open',
            ],
            [
                'title' => 'Sosial Media Marketinq Kampaniyası',
                'description' => '3 ay müddətində Instagram və Facebook hesablarını idarə edəcək sosial media mütəxəssisi axtarıram. Kontent yaratmaq, izləyicilərlə əlaqə qurmaq və reklamlar aparmaq lazımdır. Təcrübə və portfel tələb olunur.',
                'budget_type' => 'hourly',
                'budget_amount' => 25,
                'category' => 'Marketinq və Satış',
                'is_remote' => true,
                'status' => 'open',
            ],
            [
                'title' => 'Məhsul Fotoqrafiyası və Redaktə',
                'description' => 'E-ticarət mağazası üçün peşəkar məhsul fotoları lazımdır. Təxminən 50 məhsulun şəkli çəkilməli və redaktə olunmalıdır. Studiya avadanlığı mövcuddur. Bakıda görüşməklə işləmək tələb olunur.',
                'budget_type' => 'fixed',
                'budget_amount' => 400,
                'category' => 'Reklam və Dizayn',
                'location' => 'Bakı',
                'is_remote' => false,
                'status' => 'assigned',
            ],
            [
                'title' => 'Kondisioner təmiri və baxımı',
                'description' => 'Ev kondisionerimizin təmiri və qaz doldurulması lazımdır. Yaşayış Massivində yerləşir. Təcrübəli usta axtarıram.',
                'budget_type' => 'fixed',
                'budget_amount' => 100,
                'category' => 'Məişət Texnikası',
                'location' => 'Bakı, Yaşayış Massivi',
                'is_remote' => false,
                'status' => 'open',
            ],
            [
                'title' => 'Ev təmiri - elektrik və santexnika işləri',
                'description' => 'Mənzilin elektrik və santexnika işlərini görəcək təcrübəli usta lazımdır. Rozetka dəyişməsi, suyu axıdır, kranda problem var.',
                'budget_type' => 'hourly',
                'budget_amount' => 20,
                'category' => 'Təmir və Tikinti',
                'location' => 'Bakı, Nəsimi rayonu',
                'is_remote' => false,
                'status' => 'open',
            ],
            [
                'title' => 'Uşaq baxıcısı axtarıram',
                'description' => '3 yaşlı uşağım üçün aylıq baxıcı axtarıram. Həftə içi saat 9:00-dan 18:00-a qədər. Təcrübə və tövsiyyə məktubları tələb olunur.',
                'budget_type' => 'fixed',
                'budget_amount' => 800,
                'category' => 'Sağlamlıq və Qulluq',
                'location' => 'Bakı, Nərimanov rayonu',
                'is_remote' => false,
                'status' => 'open',
            ],
        ];

        foreach ($taskData as $data) {
            $category = $categories->where('name', $data['category'])->first();
            $client = $clients[array_rand($clients)];

            $task = Task::create([
                'user_id' => $client->id,
                'category_id' => $category->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => $data['description'],
                'budget_type' => $data['budget_type'],
                'budget_amount' => $data['budget_amount'],
                'location' => $data['location'] ?? null,
                'is_remote' => $data['is_remote'],
                'status' => $data['status'],
                'views_count' => rand(10, 150),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            $tasks[] = $task;
        }

        // Create applications for some tasks
        $openTasks = collect($tasks)->where('status', 'open')->take(4);
        foreach ($openTasks as $task) {
            // Each task gets 2-4 applications
            $numApplications = rand(2, 4);
            $selectedprofessionals = collect($professionals)->random($numApplications);

            foreach ($selectedprofessionals as $professional) {
                Application::create([
                    'task_id' => $task->id,
                    'user_id' => $professional->id,
                    'proposed_amount' => $task->budget_type === 'fixed'
                        ? $task->budget_amount * (rand(80, 120) / 100)
                        : $task->budget_amount * (rand(80, 120) / 100),
                    'message' => "Salam! Bu layihədə işləmək məni maraqlandırır. Müvafiq təcrübəm var və keyfiyyətli işi müddətində təhvil verə bilərəm.",
                    'estimated_days' => rand(7, 30),
                    'status' => 'pending',
                    'created_at' => now()->subDays(rand(1, 15)),
                ]);
            }
        }

        // Create completed contracts with reviews
        $completedTask = collect($tasks)->where('status', 'assigned')->first();
        if ($completedTask) {
            $professional = $professionals[0];
            $client = User::find($completedTask->user_id);

            // Create application
            $application = Application::create([
                'task_id' => $completedTask->id,
                'user_id' => $professional->id,
                'proposed_amount' => $completedTask->budget_amount,
                'message' => "Bu layihədə sizə kömək edə bilərəm! Təcrübəm və bacarıqlarım kifayətdir.",
                'estimated_days' => 14,
                'status' => 'accepted',
                'created_at' => now()->subDays(25),
            ]);

            // Create contract
            $contract = Contract::create([
                'task_id' => $completedTask->id,
                'application_id' => $application->id,
                'client_id' => $client->id,
                'professional_id' => $professional->id,
                'final_amount' => $completedTask->budget_amount,
                'status' => 'completed',
                'started_at' => now()->subDays(20),
                'completed_at' => now()->subDays(5),
                'completion_notes' => 'Layihə uğurla tamamlandı! Bütün tələblər yerinə yetirildi.',
            ]);

            // Create reviews
            Review::create([
                'contract_id' => $contract->id,
                'reviewer_id' => $client->id,
                'reviewed_id' => $professional->id,
                'rating' => 5,
                'comment' => 'Əla iş! Çox professional və vaxtında təhvil verildi. Tövsiyə edirəm.',
                'type' => 'client_to_professional',
                'created_at' => now()->subDays(4),
            ]);

            Review::create([
                'contract_id' => $contract->id,
                'reviewer_id' => $professional->id,
                'reviewed_id' => $client->id,
                'rating' => 5,
                'comment' => 'Əla müştəri. Aydın tələblər və vaxtında ödəniş. Təşəkkürlər.',
                'type' => 'professional_to_client',
                'created_at' => now()->subDays(4),
            ]);
        }

        // Create additional completed contracts for other professionals
        for ($i = 1; $i < min(count($professionals), 4); $i++) {
            $professional = $professionals[$i];
            $client = $clients[array_rand($clients)];
            $category = $categories->random();

            // Create a dummy task
            $dummyTask = Task::create([
                'user_id' => $client->id,
                'category_id' => $category->id,
                'title' => 'Previous Project',
                'slug' => Str::slug('Previous Project') . '-' . $i,
                'description' => 'Completed project',
                'budget_type' => 'fixed',
                'budget_amount' => rand(500, 2000),
                'is_remote' => true,
                'status' => 'completed',
                'created_at' => now()->subDays(rand(30, 90)),
            ]);

            $dummyApplication = Application::create([
                'task_id' => $dummyTask->id,
                'user_id' => $professional->id,
                'proposed_amount' => $dummyTask->budget_amount,
                'message' => 'Application message',
                'status' => 'accepted',
                'created_at' => now()->subDays(rand(30, 90)),
            ]);

            $dummyContract = Contract::create([
                'task_id' => $dummyTask->id,
                'application_id' => $dummyApplication->id,
                'client_id' => $client->id,
                'professional_id' => $professional->id,
                'final_amount' => $dummyTask->budget_amount,
                'status' => 'completed',
                'started_at' => now()->subDays(rand(25, 85)),
                'completed_at' => now()->subDays(rand(10, 60)),
            ]);

            // Random ratings between 4-5
            $ratings = [4, 4.5, 5];
            $rating = $ratings[array_rand($ratings)];

            Review::create([
                'contract_id' => $dummyContract->id,
                'reviewer_id' => $client->id,
                'reviewed_id' => $professional->id,
                'rating' => $rating,
                'comment' => 'Yaxşı iş. Yenidən işə götürərdim.',
                'type' => 'client_to_professional',
            ]);
        }

        $this->command->info('✅ Marketplace data seeded successfully!');
        $this->command->info("   - " . count($professionals) . " professionals created");
        $this->command->info("   - " . count($clients) . " clients created");
        $this->command->info("   - " . count($tasks) . " tasks created");
        $this->command->info("   - Applications and reviews added");
    }
}
