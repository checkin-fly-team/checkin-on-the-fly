<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'status',
        'capacity',
        'location',
        'location_description',
        'image',
        'show_organizer_profiles',
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function teamMembers(): HasMany
    {
        return $this->hasMany(EventTeam::class);
    }

    public function teamUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_team', 'event_id', 'user_id')
            ->withPivot(['role', 'assigned_at']);
    }

    public function intervals(): HasMany
    {
        return $this->hasMany(EventInterval::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(MarketingCampaign::class);
    }

    public function customFields(): HasMany
    {
        return $this->hasMany(CustomField::class);
    }
}
