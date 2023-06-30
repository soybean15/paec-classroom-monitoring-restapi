<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    //



    public function addSchedule(Request $request)
    {



        $start = $request['start'];
        $end = $request['end'];
        $day = $request['day'];
        $user_id = $request['user_id'];

        $teacher = \App\Models\Teacher::where('user_id',$user_id)->first();

        return response()->json([
            'schedule'=>$teacher->schedules
        ]);
      
        if($teacher->hasConflictingTime($start,$end,$day)){
            return new JsonResponse([
                'errors' => [
                    'start'=>['Schedule Conflict']
                ],
                'schedule'=>$teacher->schedules
            
            ], 422);

        }
       
        
           





        $validator = Validator::make($request->all(), [
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'day' => 'required',
            // Add more validation rules if needed
        ]);






        if ($validator->fails()) {
            // Return JSON response with validation errors
            return new JsonResponse([
                'errors' => $validator->errors()
            ], 422);
        }


        $schedule = \App\Models\Schedule::create([
            'start' => $request['start'],
            'end' => $request['end'],
            'day' => $request['day'],
            'room_id' => $request['room'],
            'section' => $request['prefix'] . $request['section'],
            'subject_teacher_id' => $request['subject_teacher_id']

        ]);
        return response()->json([
            'request' => $schedule
        ]);

    }

    public function getSchedule($id)
    {
        $schedules = \App\Models\Schedule::where('subject_teacher_id', $id)->get();


        return response()->json([
            'schedules' => $schedules,

        ]);
    }
}