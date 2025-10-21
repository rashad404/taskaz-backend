<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'slug' => Str::slug('Super Admin'),
            'email' => 'admin@task.az',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'is_admin' => true,
            'role' => 'admin',
        ]);

        // Create Admin
        User::create([
            'name' => 'Admin User',
            'slug' => Str::slug('Admin User'),
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'is_admin' => true,
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'Regular User',
            'slug' => Str::slug('Regular User'),
            'email' => 'user@task.az',
            'password' => Hash::make('user123'),
            'email_verified_at' => now(),
            'is_admin' => false,
            'role' => 'user',
        ]);

        $this->command->info('Admin users seeded successfully!');
        $this->command->info('Super Admin: admin@task.az / admin123');
        $this->command->info('Admin: admin@example.com / password123');
        $this->command->info('Regular User: user@task.az / user123');
    }
}