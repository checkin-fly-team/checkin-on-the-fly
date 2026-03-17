<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventInterval>
 */
class EventIntervalFactory extends Factory
{
    protected $model = EventInterval::class;

    public function definition(): array
    {
        $startHour = fake()->numberBetween(8, 17);
        $durationHours = fake()->numberBetween(1, 4);

        return [
            'event_id' => Event::factory(),
            'date' => fake()->dateTimeBetween('-1 month', '+2 months')->format('Y-m-d'),
            'start_time' => sprintf('%02d:00:00', $startHour),
            'end_time' => sprintf('%02d:00:00', min(23, $startHour + $durationHours)),
            'specific_location' => fake()->optional()->streetAddress(),
        ];
    }
}
