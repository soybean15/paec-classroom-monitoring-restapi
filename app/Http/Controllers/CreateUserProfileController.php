<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateUserProfileController extends Controller
{
    //
    public function store(Request $request){


        $user = $request->user();

        $userProfile = $user->profile;
        if (!$userProfile) {
            $userProfile = new \App\Models\UserProfile();
            $userProfile->user_id = $user->id;
        }
    
        $userProfile->firstname = $request->input('firstname');
        $userProfile->lastname = $request->input('lastname');
        $userProfile->middlename = $request->input('middlename');
        $userProfile->gender = $request->input('gender');
        $userProfile->birthdate = $request->input('birthdate');
        $userProfile->contact_number = $request->input('contact_number');
        $userProfile->image = $request->input('image');
        $userProfile->address = $request->input('address');
    
        $userProfile->save();
    
        return response()->json([
            'message' => 'User profile updated successfully.',
            
        ]);

    }
}
