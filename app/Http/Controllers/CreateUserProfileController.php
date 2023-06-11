<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateUserProfileController extends Controller
{
    //
    public function store(Request $request){


        return response()->json([
            'request' => $request->all()
        ]);

    }
}
