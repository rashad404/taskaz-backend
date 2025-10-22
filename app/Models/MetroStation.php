<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetroStation extends Model
{
    protected $fillable = [
        'city_id',
        'name_az',
        'name_en',
        'name_ru',
        'sort_order',
    ];

    protected $casts = [
        'city_id' => 'integer',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Helper method to get name by locale
    public function getName(string $locale = 'az'): string
    {
        return $this->{"name_$locale"} ?? $this->name_az;
    }
}
