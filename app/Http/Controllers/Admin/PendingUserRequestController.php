<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PendingUserRequestController extends Controller
{
    //

    public static function index()
    {
        $pendingUsers = \App\Models\User::with('userProfile')
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('pending_request');
            })
            ->distinct()
            ->get();

       

        return response()->json([
            'pendingUsers' => [
                'users' => $pendingUsers,
                'count' => $pendingUsers->count()
            ]
            


        ]);
    }

    public function acceptUser(){
        
    }
}
