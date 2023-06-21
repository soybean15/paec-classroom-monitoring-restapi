<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role'=>['required']
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        //attach role
        $roleId = $input['role'];
        $user->roles()->attach($roleId);

        
        if ($roleId == 2) {
            // Add user_id to the teacher table
            $user->teacher()->create([]);
        } elseif ($roleId == 3) {
            // Add user_id to the student table
            $user->student()->create([]);
        }

    

        //add to pending if teacher
        if($user->isTeacher()){
           \DB::table('pending_request')->insert([
                'user_id' =>$user->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }



        UserProfile::create([
            'firstname' => '',
            'lastname' => '',
            'middlename' => null,
            'gender' => null,
            'birthdate' => null,
            'contact_number' => null,
            'image' => null,
            'address' => null,
            'user_id' => $user->id,
        ]);
        return $user;
    }
}
