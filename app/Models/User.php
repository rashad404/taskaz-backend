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
        'slug',
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
        'type',
        'bio',
        'location',
        'city_id',
        'neighborhood_id',
        'status',
        'email_verified_at',
        'phone_verified_at',
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
     * Get city relation.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get neighborhood relation.
     */
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    /**
     * Get tasks posted by this user (as client).
     */
    public function postedTasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get applications submitted by this user (as freelancer).
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get contracts where this user is the client.
     */
    public function clientContracts()
    {
        return $this->hasMany(Contract::class, 'client_id');
    }

    /**
     * Get contracts where this user is the freelancer.
     */
    public function freelancerContracts()
    {
        return $this->hasMany(Contract::class, 'freelancer_id');
    }

    /**
     * Get reviews written by this user.
     */
    public function writtenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * Get reviews received by this user.
     */
    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    /**
     * Get messages sent by this user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get messages received by this user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get average rating from reviews.
     */
    public function getAverageRating()
    {
        return $this->receivedReviews()->avg('rating');
    }

    /**
     * Check if user is a client.
     */
    public function isClient(): bool
    {
        return in_array($this->type, ['client', 'both']);
    }

    /**
     * Check if user is a freelancer.
     */
    public function isFreelancer(): bool
    {
        return in_array($this->type, ['freelancer', 'both']);
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
