<?php


namespace App\Http\Traits;

trait UserTrait
{
   public function createUserProfile(){

    \App\Models\UserProfile::create([
        'firstname' => '',
        'lastname' => '',
        'middlename' => null,
        'gender' => null,
        'birthdate' => null,
        'contact_number' => null,
        'image' => null,
        'address' => null,
        'user_id' => $this->id,
    ]);
   }

   public function isPending(){
    if($this->isTeacher()){
        \DB::table('pending_request')->insert([
             'user_id' =>$this->id,
             'created_at' => now(),
             'updated_at' => now()
         ]);
     }
   }

   public function attachRole($roleId){
    $this->roles()->attach($roleId);

        
        if ($roleId == 2) {
            // Add user_id to the teacher table
            $this->teacher()->create([]);
        } elseif ($roleId == 3) {
            // Add user_id to the student table
            $this->student()->create([]);
        }

   }

}