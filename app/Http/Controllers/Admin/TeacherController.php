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



        return response()->json([
            'subjects' => $subjects,
        ]);

    }
}