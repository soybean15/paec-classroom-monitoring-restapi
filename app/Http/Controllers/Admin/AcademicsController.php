<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcademicsController extends Controller
{

     public function index(){

        $subjects = \App\Models\Subject::all();

        $count=0;
        foreach($subjects as $subject){
            
            $subject->image = "https://source.unsplash.com/random/250x150/?books&{$count}";
            $count++;
        }

        $courses =  \App\Models\Course::all();

        return response()->json([
            'subjects' => $subjects,
            'courses'=>$courses
        ]);

     }
    
     public function getSubjects(){

        return response()->json([
            'subjects' => 'User ID not found in pending requests'
        ]);

     }

     public function getCourses(){

     }
}
