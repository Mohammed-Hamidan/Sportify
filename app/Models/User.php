<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'role',
        'password',
        'gender',
        'position',
        'is_available',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_available' => 'boolean',
        ];
    }

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class, 'owner_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'player_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members')->withTimestamps()->withPivot('position', 'joined_at');
    }

    public function captainTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'captain_id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
