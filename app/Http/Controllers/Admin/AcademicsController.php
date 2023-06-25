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
     

        return response()->json([
            'subjects' => $subjects,
            'courses' => $courses,
            'subject_count' => $subjects->count(),
            'course_count' => $courses->count()

        ]);

    }

    public function getSubjects()
    {

        $subjects = \App\Models\Subject::orderBy('name')->get();

        $formattedSubjects = $subjects->map(function ($subject) {
            $subject->formatted_date = Carbon::parse($subject->created_at)->format('M d, Y');
            return $subject;
        });



        foreach ($subjects as $subject) { 
            $subject->course_name = $subject->course_name;
           
       
            switch ($subject->year_level) {
                case 1: {
                        $subject->year_level .= "st";
                        break;
                    }
                case 2: {
                        $subject->year_level .= "nd";
                        break;
                    }
                case 3: {
                        $subject->year_level .= "rd";
                        break;
                    }
                default:
                    $subject->year_level = "{$subject->year_level}th";
                    break;
            }
        }

        return response()->json([
            'subjects' => $formattedSubjects
        ]);

    }

    public function getCourses()
    {
        $courses = \App\Models\Course::all();
        return response()->json([
            'courses' => $courses
        ]);
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
            'unit' => 'required',
            'year_level'=>'required',
            'semester'=> 'required'
        ]);
        $subject = \App\Models\Subject::create([
            'name' => $validatedData['name'],
            'unit' => $validatedData['unit'],
            'year_level'=>$validatedData['year_level'],
            'semester'=>$validatedData['semester'],
            'course_id'=>$request['course_id']
        ]);

        $subject->image = "https://source.unsplash.com/random/250x150/?college";
        $subject->course_name = $subject->course_name;
        return response()->json([
            'message' => "New Subject added",
            'subject' => $subject
        ]);

    }
}