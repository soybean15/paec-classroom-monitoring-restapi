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

        $conflictingSchedules = \DB::table('schedules')
            ->where(function ($query) use ($start, $end,$day) {

                $query->where('end', '>', $start)
                    ->where('start', '<', $end)
                       ->where('day', $day);

            })->where('subject_teacher_id', $request['subject_teacher_id'])
            ->get();

        if (!$conflictingSchedules->isEmpty()) {
            return new JsonResponse([
                'errors' => [
                    'start'=>['Schedule Conflict']
                ]
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