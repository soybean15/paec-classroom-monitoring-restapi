<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        $users = \DB::table('users')
            ->join('pending_request', 'users.id', '=', 'pending_request.user_id')
            ->select('users.*')
            ->distinct()
            ->get();

        return response()->json([
            'pendingUsers' => $users,

        ]);
    }

    public static function getUsers()
    {
        $pendingUsers = \DB::table('users')
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('pending_request');
            })
            ->distinct()
            ->get();

        $users = \DB::table('users')
            ->whereNotIn('id', function ($query) {
                $query->select('user_id')
                    ->from('pending_request');
            })
            ->distinct()
            ->get();

        return response()->json([
            'pendingUsers' => $pendingUsers,
            'users' => $users

        ]);
    }
}