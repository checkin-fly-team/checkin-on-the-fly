<?php

namespace Database\Factories;

use App\Models\CustomField;
use App\Models\Participant;
use App\Models\ParticipantAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ParticipantAnswer>
 */
class ParticipantAnswerFactory extends Factory
{
    protected $model = ParticipantAnswer::class;

    public function definition(): array
    {
        return [
            'participant_id' => Participant::factory(),
            'custom_field_id' => CustomField::factory(),
            'value' => fake()->sentence(),
        ];
    }
}
