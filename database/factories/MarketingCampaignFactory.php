<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\MarketingCampaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MarketingCampaign>
 */
class MarketingCampaignFactory extends Factory
{
    protected $model = MarketingCampaign::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'channel' => fake()->randomElement(['email', 'whatsapp']),
            'subject' => fake()->optional()->sentence(5),
            'content' => fake()->paragraph(),
            'days_before' => fake()->optional()->numberBetween(1, 30),
            'scheduled_at' => fake()->optional()->dateTimeBetween('-10 days', '+30 days'),
            'is_active' => fake()->boolean(80),
        ];
    }
}
