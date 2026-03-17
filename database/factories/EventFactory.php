<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'organizer_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['upcoming', 'ongoing', 'complete', 'cancelled']),
            'capacity' => fake()->optional()->numberBetween(30, 500),
            'location' => fake()->city(),
            'location_description' => fake()->optional()->sentence(8),
            'image' => fake()->optional()->imageUrl(1200, 600, 'business', true),
            'show_organizer_profiles' => fake()->boolean(80),
        ];
    }
}
