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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Client
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('budget_type', ['fixed', 'hourly'])->default('fixed');
            $table->decimal('budget_amount', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->enum('status', ['open', 'assigned', 'completed', 'cancelled'])->default('open');
            $table->dateTime('deadline')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
