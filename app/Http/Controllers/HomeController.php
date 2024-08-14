<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\Course;
use App\Models\Assignments;
use App\Models\CoursesLo;
use app\Models\Lessons;
use App\Models\Material;

class HomeController extends Controller
{
    //
    public function index()
    {
        $majors = Major::all();
        return view('dashboard')->with('majors', $majors);
    }

    public function showDetail($id)
    {
        $courses = Course::findOrFail($id);
        $coursesLo = CoursesLo::where('course_id', $id)->get();
        $materials = Material::where('course_id', $id)->get();
        $assignments = Assignments::where('course_id', $id)->get();
        // $lessons = Lessons::where('course_id', $id)->get();

        return view('user/detail', compact('courses', 'coursesLo', 'materials', 'assignments'));
    }

    public function showCourses($id)
    {
        $majors = Major::with('courses')->findOrFail($id);
        return view('user/course', compact('majors'));
    }
}
