<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed languages
        $this->call([
            LanguageSeeder::class,
        ]);

        // Seed admin user
        $this->call([
            AdminSeeder::class,
        ]);

        // Seed categories
        $this->call([
            CategorySeeder::class,
        ]);

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'slug' => Str::slug('Test User'),
            'email' => 'test@example.com',
            'type' => 'both',
        ]);

        // Seed marketplace data (tasks, freelancers, applications, etc.)
        $this->call([
            TaskMarketplaceSeeder::class,
        ]);
    }
}