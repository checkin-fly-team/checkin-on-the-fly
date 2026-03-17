<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Participant>
 */
class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        $isCheckedIn = fake()->boolean(55);

        return [
            'event_id' => Event::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->e164PhoneNumber(),
            'qr_code_token' => (string) Str::uuid(),
            'is_spontaneous' => fake()->boolean(20),
            'email_verified_at' => fake()->boolean(90) ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'checked_in_at' => $isCheckedIn ? fake()->dateTimeBetween('-10 days', 'now') : null,
        ];
    }
}
