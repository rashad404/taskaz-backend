<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnnouncement extends Model
{
    protected $fillable = [
        'user_id',
        'announcement_type',
        'seen_at',
        'dismissed_at',
    ];

    protected $casts = [
        'seen_at' => 'datetime',
        'dismissed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the announcement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the announcement has been dismissed.
     */
    public function isDismissed(): bool
    {
        return !is_null($this->dismissed_at);
    }

    /**
     * Check if the announcement has been seen.
     */
    public function isSeen(): bool
    {
        return !is_null($this->seen_at);
    }

    /**
     * Mark announcement as seen.
     */
    public function markAsSeen(): self
    {
        if (is_null($this->seen_at)) {
            $this->seen_at = now();
            $this->save();
        }
        return $this;
    }

    /**
     * Mark announcement as dismissed.
     */
    public function markAsDismissed(): self
    {
        if (is_null($this->dismissed_at)) {
            $this->dismissed_at = now();
            $this->save();
        }
        return $this;
    }
}
