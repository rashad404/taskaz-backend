<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'google_id',
        'facebook_id',
        'avatar',
        'provider',
        'provider_id',
        'telegram_chat_id',
        'whatsapp_number',
        'slack_webhook',
        'push_token',
        'notification_preferences',
        'timezone',
        'locale',
        'is_admin',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
        'facebook_id',
        'provider_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'notification_preferences' => 'array',
        ];
    }

    /**
     * Get the user's personal alerts.
     */
    public function personalAlerts()
    {
        return $this->hasMany(PersonalAlert::class);
    }

    /**
     * Get the user's alert history.
     */
    public function alertHistory()
    {
        return $this->hasMany(AlertHistory::class);
    }

    /**
     * Check if user has a specific notification channel configured.
     */
    public function hasNotificationChannel($channel)
    {
        switch ($channel) {
            case 'email':
                return !empty($this->email) && $this->email_verified_at !== null;
            case 'sms':
                return !empty($this->phone) && $this->phone_verified_at !== null;
            case 'telegram':
                return !empty($this->telegram_chat_id);
            case 'whatsapp':
                return !empty($this->whatsapp_number);
            case 'slack':
                return !empty($this->slack_webhook);
            case 'push':
                return !empty($this->push_token);
            default:
                return false;
        }
    }

    /**
     * Get available notification channels for this user.
     */
    public function getAvailableNotificationChannels()
    {
        $channels = [];

        if ($this->hasNotificationChannel('email')) {
            $channels[] = 'email';
        }
        if ($this->hasNotificationChannel('sms')) {
            $channels[] = 'sms';
        }
        if ($this->hasNotificationChannel('telegram')) {
            $channels[] = 'telegram';
        }
        if ($this->hasNotificationChannel('whatsapp')) {
            $channels[] = 'whatsapp';
        }
        if ($this->hasNotificationChannel('slack')) {
            $channels[] = 'slack';
        }
        if ($this->hasNotificationChannel('push')) {
            $channels[] = 'push';
        }

        return $channels;
    }
}
