<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //

    public function addSubjects(Request $request, $id){

        $subjects = [];
        foreach ($request->subjects as $subject) {
            \DB::table('subject_teacher')->insert([
                'subject_id' => $subject['id'],
                'teacher_id' => $id,
                'school_year_id' => $request->settings['school_year_id'],
                'semester' => $request->settings['semester'],
            ]);
        
            $subject = \App\Models\Subject::find($subject['id']);
            $subjects[] = $subject;
        }
        

        return response()->json([
            'message'=>"Subject(s) added ",
            'subjects'=>$subjects
           
        ]);
    
    }

    public function getTeacherSubjects(Request $request){
        $userId = $request->input('user_id');
        $teacher = \App\Models\Teacher::where('user_id', $userId)->first();


    //     $schoolYearId = $request->settings['school_year_id'];
    //     $teacherId = $request->input('user_id');
    //     $semester = $request->settings['semester'];

    // $subjects = \App\Models\Subject::whereHas('teacher_subject', function ($query) use ($schoolYearId, $teacherId, $semester) {
    //     $query->where('school_year_id', $schoolYearId)
    //         ->where('teacher_id', $teacherId)
    //         ->where('semester', $semester);
    // })->get();



        return response()->json([
            'subjects'=>$teacher->subjects,
            'user'=> $teacher->user

           
        ]);

    }
}
