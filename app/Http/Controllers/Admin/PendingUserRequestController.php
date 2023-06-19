<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PendingUserRequestController extends Controller
{
    //

    public static function index()
    {
        //$currentDateTime = Carbon::now();

        $pendingUsers = \App\Models\User::with('userProfile')
            ->whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('pending_request');
            })
            ->distinct()
            ->get();

            foreach($pendingUsers as $user){
                $user->created_at_diff = Carbon::parse($user->created_at)->diffForHumans();
            }

       

        return response()->json([
            'pendingUsers' => [
                'users' => $pendingUsers,
                'count' => $pendingUsers->count()
            ]
            


        ]);
    }

    public function acceptUser(String $id){
      
       
        $deletedRows = \DB::table('pending_request')->where('user_id', $id)->delete();

        if ($deletedRows > 0) {
            // Deletion was successful
            return response()->json([
                'message' => 'User ID removed from pending requests'
            ]);
        } else {
            // No rows were deleted
            return response()->json([
                'message' => 'User ID not found in pending requests'
            ]);
        }
        
    
    }
}
