<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Major;
use App\Models\Assignments;

class GuestController extends Controller
{
    //

    public function index()
    {
        $majors = Major::all();
        return view('guest/index')->with('majors', $majors);
    }

    public function showDetail($id)
    {
        $courses = Course::findOrFail($id);
        $assignments = Assignments::where('course_id', $id)->get();
    
        return view('guest/detail', compact('courses', 'assignments'));
    }

    public function showCourses($id)
    {
        $majors = Major::with('courses')->findOrFail($id);
        return view('guest/course', compact('majors'));
    }
}
