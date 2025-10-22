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
        // Update tasks table
        Schema::table('tasks', function (Blueprint $table) {
            // Drop foreign key for neighborhood_id
            $table->dropForeign(['neighborhood_id']);

            // Rename neighborhood_id to district_id
            $table->renameColumn('neighborhood_id', 'district_id');
        });

        // Add back foreign key and new fields for tasks
        Schema::table('tasks', function (Blueprint $table) {
            // Re-add foreign key for district_id pointing to districts table
            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();

            // Add new location fields
            $table->foreignId('settlement_id')->nullable()->after('district_id')->constrained('settlements')->nullOnDelete();
            $table->foreignId('metro_station_id')->nullable()->after('settlement_id')->constrained('metro_stations')->nullOnDelete();

            $table->index('settlement_id');
            $table->index('metro_station_id');
        });

        // Update users table
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key for neighborhood_id
            $table->dropForeign(['neighborhood_id']);

            // Rename neighborhood_id to district_id
            $table->renameColumn('neighborhood_id', 'district_id');
        });

        // Add back foreign key and new fields for users
        Schema::table('users', function (Blueprint $table) {
            // Re-add foreign key for district_id pointing to districts table
            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();

            // Add new location fields
            $table->foreignId('settlement_id')->nullable()->after('district_id')->constrained('settlements')->nullOnDelete();
            $table->foreignId('metro_station_id')->nullable()->after('settlement_id')->constrained('metro_stations')->nullOnDelete();

            $table->index('settlement_id');
            $table->index('metro_station_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse tasks table changes
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['settlement_id']);
            $table->dropForeign(['metro_station_id']);
            $table->dropForeign(['district_id']);
            $table->dropColumn(['settlement_id', 'metro_station_id']);

            $table->renameColumn('district_id', 'neighborhood_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->nullOnDelete();
        });

        // Reverse users table changes
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['settlement_id']);
            $table->dropForeign(['metro_station_id']);
            $table->dropForeign(['district_id']);
            $table->dropColumn(['settlement_id', 'metro_station_id']);

            $table->renameColumn('district_id', 'neighborhood_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->nullOnDelete();
        });
    }
};
