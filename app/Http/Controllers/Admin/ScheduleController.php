<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //

    public function addSchedule(Request $request){


        $schedule = \App\Models\Schedule::create([
            'start'=>$request['start'],
            'end'=> $request['end'],
            'day'=>$request['day'],
            'room_id'=>$request['room'],
            'section'=> $request['prefix'] . $request['section'],
            'subject_teacher_id'=>$request['subject_teacher_id']

        ]);
        return response()->json([
            'request'=>$schedule
        ]);

    }

    public function getSchedule($id){
        $schedules = \App\Models\Schedule::where('subject_teacher_id',$id)->get();


        return response()->json([
            'schedules'=>$schedules,
         
        ]);
    }
}
