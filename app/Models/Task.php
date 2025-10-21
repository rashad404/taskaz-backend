<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'slug',
        'title',
        'description',
        'budget_type',
        'budget_amount',
        'location',
        'is_remote',
        'status',
        'deadline',
        'views_count',
    ];

    protected $casts = [
        'budget_amount' => 'decimal:2',
        'is_remote' => 'boolean',
        'deadline' => 'datetime',
        'views_count' => 'integer',
    ];

    // Relationships
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    // Helper methods
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
