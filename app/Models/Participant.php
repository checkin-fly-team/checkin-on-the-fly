<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'qr_code_token',
        'is_spontaneous',
        'email_verified_at',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'is_spontaneous' => 'boolean',
            'email_verified_at' => 'datetime',
            'checked_in_at' => 'datetime',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function checkinLogs(): HasMany
    {
        return $this->hasMany(CheckinLog::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ParticipantAnswer::class);
    }
}
