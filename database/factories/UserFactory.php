<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }


    public function configure()
    {
        return $this->afterCreating(function (\App\Models\User $user) {
            // Create user profile
            $userProfile = \App\Models\UserProfile::create([
                'firstname' => $this->faker->firstName(),
                'lastname' => $this->faker->lastName(),
                // Other profile attributes
                'user_id' => $user->id,
            ]);

            $roleId = rand(2, 3); // Generate a random number between 2 and 3 (inclusive)

           

            if($user->email === 'marlonpadilla1593@gmail.com'){
                $user->roles()->attach(1);
            }else{
                $user->roles()->attach($roleId);
                if ($roleId === 2) {
                    $user->teacher()->create([]);
                } 
            }

           
            //add to pending if teacher
            if ($user->isTeacher()) {
                \DB::table('pending_request')->insert([
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}