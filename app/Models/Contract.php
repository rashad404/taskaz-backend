<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    protected $fillable = [
        'task_id',
        'application_id',
        'client_id',
        'freelancer_id',
        'final_amount',
        'status',
        'started_at',
        'completed_at',
        'completion_notes',
    ];

    protected $casts = [
        'final_amount' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
