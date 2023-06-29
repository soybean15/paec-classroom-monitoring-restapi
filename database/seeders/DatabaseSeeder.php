<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Course::factory(5)->create();
         \App\Models\User::factory(10)->create();
         \App\Models\Subject::factory(20)->create();
         \App\Models\Room::factory(10)->create();
      
        $user = \App\Models\User::factory()->create([
            'name' => 'Marlon123',
            'email' => 'marlonpadilla1593@gmail.com',
        ]);

        // $userProfile =  \App\Models\UserProfile::create([
        //     'firstname' => 'Marlon',
        //     'lastname' => 'Padilla',
        //     'middlename' => null,
        //     'gender' => null,
        //     'birthdate' => null,
        //     'contact_number' => null,
        //     'image' => null,
        //     'address' => null,
        //     'user_id' => $user->id,
        // ]);


        // $user->roles()->attach(1);
        
      
    }
}
