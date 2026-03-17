<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventTeam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventTeam>
 */
class EventTeamFactory extends Factory
{
    protected $model = EventTeam::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'role' => fake()->randomElement(['organizer', 'scan_only']),
            'assigned_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
