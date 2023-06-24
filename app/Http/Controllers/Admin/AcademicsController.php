<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AcademicsController extends Controller
{

    public function index()
    {

        $subjects = \App\Models\Subject::all();
        $courses = \App\Models\Course::all();
        $count = 0;
        foreach ($subjects as $subject) {

            $subject->image = "https://source.unsplash.com/random/250x150/?books&{$count}";
            $count++;
        }

        foreach ($courses as $course) {

            $course->image = "https://source.unsplash.com/random/250x150/?college&{$count}";
            $count++;
        }



        return response()->json([
            'subjects' => $subjects,
            'courses' => $courses,
            'subject_count' => $subjects->count(),
            'course_count'=>$courses->count()
            
        ]);

    }

    public function getSubjects()
    {

        $subjects = \App\Models\Subject::orderBy('name')->get();

        // $formattedSubjects = $subjects->map(function ($subject) {
        //     $subject->created_at = Carbon::parse($subject->created_at)->format('F j, Y \a\t h:i A');
        //     return $subject;
        // });

        $formattedSubjects = $subjects->map(function ($subject) {
            $subject->formatted_date = Carbon::parse($subject->created_at)->format('M d, Y');
            return $subject;
        });
        return response()->json([
            'subjects' =>  $formattedSubjects
        ]);

    }

    public function getCourses()
    {

    }

    public function addCourse(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        $course = \App\Models\Course::create([
            'name' => $validatedData['name'],
            'description' => $request['description']
        ]);

        $course->image = "https://source.unsplash.com/random/250x150/?college";

        return response()->json([
            'message' => "New course added",
            'course' => $course
        ]);

    }
    public function addSubject(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'unit' => 'required'
        ]);
        $subject = \App\Models\Subject::create([
            'name' => $validatedData['name'],
            'unit' => $request['unit']
        ]);
  
        $subject->image = "https://source.unsplash.com/random/250x150/?college";

        return response()->json([
            'message' => "New Subject added",
            'subject' => $subject
        ]);

    }
}