<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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


    public function filterByRole(string $roleId)
    {

        $users = \App\Models\User::with('userProfile')
        ->with('roles')
        ->whereNotIn('id', function ($query) {
                $query->select('user_id')
                    ->from('pending_request');
            })
            ->whereIn('id', function ($query) use ($roleId){
                $query->select('user_id')
                    ->from('role_user')
                    ->where('role_id', $roleId); // Replace $teacherRoleId with the actual ID of the "teacher" role
            })
            ->distinct()
            ->paginate(5);



            return response()->json([
                'users' => $users
    
            ]);


    }


}