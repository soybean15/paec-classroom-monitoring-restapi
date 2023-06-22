<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->lexify(str_repeat('?', 4));
        $name = strtoupper($name);


        return [
            'name' => $name,
            'description' => $this->faker->sentence(10, true),
            
        ];
    }
}