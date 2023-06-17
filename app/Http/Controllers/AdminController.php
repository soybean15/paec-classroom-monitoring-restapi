<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        $users = \DB::table('users')
            ->join('pending_request', 'users.id', '=', 'pending_request.user_id')
            ->select('users.*')
            ->distinct()
            ->get();

            return response()->json([
                'users' => $users,
                             
            ]);
    }

    public static function getUsersWithPendingRequests()
    {
        
    }
}
