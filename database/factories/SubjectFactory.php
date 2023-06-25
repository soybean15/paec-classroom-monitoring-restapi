<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> $this->faker->jobTitle(),
            'unit'=>$this->faker->numberBetween(1,4),
            'year_level'=>$this->faker->numberBetween(1,4),
            'semester'=>$this->faker->numberBetween(1,2),
            'course_id'=>$this->faker->numberBetween(1,4)
        ];
    }
}
