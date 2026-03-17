<?php

namespace Database\Factories;

use App\Models\CheckinLog;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CheckinLog>
 */
class CheckinLogFactory extends Factory
{
    protected $model = CheckinLog::class;

    public function definition(): array
    {
        return [
            'participant_id' => fake()->boolean(85) ? Participant::factory() : null,
            'scanned_by_user_id' => User::factory(),
            'result' => fake()->randomElement(['success', 'duplicate', 'invalid', 'expired']),
            'raw_qr_data' => fake()->optional()->sha1(),
            'scanned_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
