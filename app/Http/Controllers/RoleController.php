<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = \App\Models\Role::where('name', '!=', 'Admin')->get();
        return response()->json([
            'roles' => $roles
        ]);

    }


}