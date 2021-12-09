<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // COURSE ENROLLMENT API - POST
    public function courseEnrollment(Request $request) {
        // VALIDATION
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'total_videos'=>'required'
        ]);

        // CREATE COURSE OBJECT
        $course = new Course();

        $course->user_id = auth()->user()->id;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->total_videos = $request->total_videos;
        
        $course->save();

        // SEND RESPONSE
        return response()->json([
            'status' => 1,
            'message' => 'Course created successfully'
        ]);


    }

    // TOTAL COURSE ENROLLMENT API - GET
    public function totalCourses() {

    }

    // DELETE COURSE API - GET
    public function deleteCourse($id) {

    }


}
