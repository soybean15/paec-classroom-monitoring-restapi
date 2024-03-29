<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //

    public function addSubjects(Request $request, $id)
    {

        $subjects = [];
        foreach ($request->subjects as $subject) {
            $subjectTeacherId = \DB::table('subject_teacher')->insertGetId([
                'subject_id' => $subject['id'],
                'teacher_id' => $id,
                'school_year_id' => $request->settings['school_year_id'],
                'semester' => $request->settings['semester'],
            ]);


            $subject = \App\Models\Subject::find($subject['id']);
            $subject->pivot_id = $subjectTeacherId;
            $subjects[] = $subject;
        }


        return response()->json([
            'message' => "Subject(s) added ",
            'subjects' => $subjects

        ]);

    }

    public function getTeacherSubjects(Request $request)
    {
        $userId = $request->input('user_id');
        $teacher = \App\Models\Teacher::where('user_id', $userId)->first();


        $schoolYearId = $request->settings['school_year_id'];
        $semester = $request->settings['semester'];

      



        $subjects = $teacher->teacherSubjects($schoolYearId, $semester)->get();
        
        $subjects = $subjects->map(function ($subject) {
            $schedules = \App\Models\Schedule::where('subject_teacher_id', $subject->pivot_id)->get();
            $subject->schedules = $schedules;
            return $subject;
        });

        return response()->json([
            'subjects' => $subjects,
        ]);

    }

    public function getClasses(Request $request){

        $userId = $request->input('user_id');
        $teacher = \App\Models\Teacher::where('user_id', $userId)->first();

        $settings = \DB::table('settings')->get();

        $schoolYearId = $settings[0]->school_year_id;
        $semester = $settings[0]->semester;

        $subjects = $teacher->teacherSubjects($schoolYearId, $semester)->get();


        $schedules=[
           
        ];
        
       foreach($subjects as $subject){

            $_schedules=\App\Models\Schedule::where('subject_teacher_id', $subject->pivot_id)->get();

            foreach($_schedules as $schedule){
                $schedules[$schedule->day][] = $schedule;
            }

       }


        


       // $teacher->load(['classes']);
        return response()->json([
            'classes'=>$subjects,
            'schedules'=>$schedules
        ]);

    }
}