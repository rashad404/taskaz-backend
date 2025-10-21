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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'bank_transfer', 'online'])->default('cash');
            $table->enum('status', ['pending', 'sent', 'confirmed'])->default('pending');
            $table->boolean('client_confirmed')->default(false);
            $table->boolean('freelancer_confirmed')->default(false);
            $table->text('notes')->nullable();
            $table->string('transaction_id')->nullable(); // For future online payments
            $table->string('gateway')->nullable(); // stripe, paypal, etc.
            $table->decimal('fee_amount', 10, 2)->nullable();
            $table->decimal('net_amount', 10, 2)->nullable();
            $table->dateTime('client_confirmed_at')->nullable();
            $table->dateTime('freelancer_confirmed_at')->nullable();
            $table->timestamps();

            $table->index(['contract_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
