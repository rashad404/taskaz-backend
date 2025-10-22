<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'contract_id',
        'amount',
        'method',
        'status',
        'client_confirmed',
        'professional_confirmed',
        'notes',
        'transaction_id',
        'gateway',
        'fee_amount',
        'net_amount',
        'client_confirmed_at',
        'professional_confirmed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'client_confirmed' => 'boolean',
        'professional_confirmed' => 'boolean',
        'client_confirmed_at' => 'datetime',
        'professional_confirmed_at' => 'datetime',
    ];

    // Relationships
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    // Helper methods
    public function isFullyConfirmed(): bool
    {
        return $this->client_confirmed && $this->professional_confirmed;
    }

    public function confirmByClient(): void
    {
        $this->update([
            'client_confirmed' => true,
            'client_confirmed_at' => now(),
        ]);

        if ($this->isFullyConfirmed()) {
            $this->update(['status' => 'confirmed']);
        }
    }

    public function confirmByprofessional(): void
    {
        $this->update([
            'professional_confirmed' => true,
            'professional_confirmed_at' => now(),
        ]);

        if ($this->isFullyConfirmed()) {
            $this->update(['status' => 'confirmed']);
        }
    }
}
