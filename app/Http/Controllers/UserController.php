<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(String $id){
        $user = \App\Models\User::with('userProfile')->with('roles')->find($id);
        return response()->json([
            'user' => $user ,
           
            
        ]);

    }
    public function store(Request $request){


        $user = $request->user();

        $userProfile = \App\Models\UserProfile::where('user_id', $user->id)->first();
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
        //$userProfile->image = $request->input('image');
        $userProfile->address = $request->input('address');
    
        if($file = $request->file('image')){
            $userProfile->restoreImage('images/users', $file);
        }

        $userProfile->save();
    
        return response()->json([
            'message' => $user,
            'profile' => $userProfile,
            'id'=>$user->id
            
        ]);

    }

    
}
