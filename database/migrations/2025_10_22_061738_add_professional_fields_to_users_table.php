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
        Schema::table('users', function (Blueprint $table) {
            // Professional details
            $table->decimal('hourly_rate', 10, 2)->nullable()->after('location');
            $table->json('skills')->nullable()->after('hourly_rate');
            $table->json('portfolio_items')->nullable()->after('skills');

            // Professional application status
            $table->enum('professional_status', ['pending', 'approved', 'rejected'])->nullable()->after('portfolio_items');
            $table->timestamp('professional_application_date')->nullable()->after('professional_status');
            $table->timestamp('professional_approved_at')->nullable()->after('professional_application_date');
            $table->text('professional_rejected_reason')->nullable()->after('professional_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'hourly_rate',
                'skills',
                'portfolio_items',
                'professional_status',
                'professional_application_date',
                'professional_approved_at',
                'professional_rejected_reason'
            ]);
        });
    }
};
