<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    protected $appends = ['avatar_url'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->avatar)) {
            return $this->defaultAvatarUrl();
        }

        if (Str::startsWith($this->avatar, ['http://', 'https://'])) {
            return $this->avatar;
        }

        $disk = Storage::disk('public');
        $candidates = [
            "avatars/{$this->avatar}",
            "photos_avatars/{$this->avatar}",
            $this->avatar,
        ];

        foreach ($candidates as $path) {
            if ($disk->exists($path)) {
                return Storage::url($path);
            }
        }

        if (Str::startsWith($this->avatar, 'storage/')) {
            return asset($this->avatar);
        }

        return $this->defaultAvatarUrl();
    }

    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function eventTeamAssignments(): HasMany
    {
        return $this->hasMany(EventTeam::class);
    }

    public function teamEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_team', 'user_id', 'event_id')
            ->withPivot(['role', 'assigned_at']);
    }

    public function checkinLogs(): HasMany
    {
        return $this->hasMany(CheckinLog::class, 'scanned_by_user_id');
    }

    private function defaultAvatarUrl(): string
    {
        $name = urlencode($this->name ?: 'User');

        return "https://ui-avatars.com/api/?name={$name}&background=0D8ABC&color=fff";
    }
}
