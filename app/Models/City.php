<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'name_az',
        'name_en',
        'name_ru',
        'has_neighborhoods',
        'sort_order',
    ];

    protected $casts = [
        'has_neighborhoods' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function neighborhoods(): HasMany
    {
        return $this->hasMany(Neighborhood::class)->orderBy('sort_order');
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
