<?php

namespace Database\Factories;

use App\Models\CustomField;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomField>
 */
class CustomFieldFactory extends Factory
{
    protected $model = CustomField::class;

    public function definition(): array
    {
        $fieldType = fake()->randomElement(['text', 'textarea', 'dropdown', 'range', 'checkbox']);

        $options = null;
        if ($fieldType === 'dropdown') {
            $options = ['Option A', 'Option B', 'Option C'];
        }
        if ($fieldType === 'range') {
            $options = ['min' => 1, 'max' => 10, 'step' => 1];
        }

        return [
            'event_id' => Event::factory(),
            'label' => fake()->words(2, true),
            'field_type' => $fieldType,
            'options' => $options,
            'is_required' => fake()->boolean(40),
            'order' => fake()->numberBetween(1, 20),
        ];
    }
}
