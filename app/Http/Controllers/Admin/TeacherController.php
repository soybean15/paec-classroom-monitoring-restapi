<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //

    public function addSubjects(Request $request, $id){

        foreach($request->subjects as $subject){
            \DB::table('teacher_subject')->insert([
                'subject_id' => $subject['id'],
                'teacher_id'=>$id,
                'school_year_id'=>$request->settings['school_year_id'],
                'semester'=>$request->settings['semester'],
            ]);

        }

        return response()->json([
            'message'=>"Subject(s) added "
           
        ]);
    
    }

    public function getTeacherSubjects(Request $request){

        $teacher = \App\Models\Teacher::find( $request->input('user_id'));


    //     $schoolYearId = $request->settings['school_year_id'];
    //     $teacherId = $request->input('user_id');
    //     $semester = $request->settings['semester'];

    // $subjects = \App\Models\Subject::whereHas('teacher_subject', function ($query) use ($schoolYearId, $teacherId, $semester) {
    //     $query->where('school_year_id', $schoolYearId)
    //         ->where('teacher_id', $teacherId)
    //         ->where('semester', $semester);
    // })->get();



        return response()->json([
            'teacher'=>$teacher->subjects,
            'request'=>$request->settings
           
        ]);

    }
}
