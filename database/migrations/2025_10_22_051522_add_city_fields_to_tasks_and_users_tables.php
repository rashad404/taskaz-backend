<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add city and neighborhood fields to tasks table
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->after('location')->constrained()->nullOnDelete();
            $table->foreignId('neighborhood_id')->nullable()->after('city_id')->constrained()->nullOnDelete();

            $table->index('city_id');
            $table->index('neighborhood_id');
        });

        // Add city and neighborhood fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->after('location')->constrained()->nullOnDelete();
            $table->foreignId('neighborhood_id')->nullable()->after('city_id')->constrained()->nullOnDelete();
        });

        // Clear existing location data as instructed by user
        DB::table('tasks')->update(['location' => null]);
        DB::table('users')->update(['location' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['neighborhood_id']);
            $table->dropColumn(['city_id', 'neighborhood_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['neighborhood_id']);
            $table->dropColumn(['city_id', 'neighborhood_id']);
        });
    }
};
