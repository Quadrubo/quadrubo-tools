<?php

namespace Database\Factories;

use App\Models\Habit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Habit>
 */
class HabitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Habit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'question' => $this->faker->sentence(),
            'notes' => $this->faker->text(),
            'color' => $this->faker->hexColor(),
            'times' => $this->faker->randomDigitNotNull(),
            'multiplier' => $this->faker->randomDigitNotNull(),
            'unit' => $this->faker->randomElement(['day', 'month', 'week', 'year'])
        ];
    }
}
