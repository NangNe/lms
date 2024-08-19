<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\Course;
use App\Models\Assignments;
use App\Models\CoursesLo;
use Illuminate\Support\Facades\Storage;

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
        $lessons = \App\Models\Lessons::where('course_id', $id)->get();


        return view('user/detail', compact('courses', 'coursesLo', 'materials', 'assignments','lessons'));
    }

    public function showCourses($id)
    {
        $majors = Major::with('courses')->findOrFail($id);
        return view('user/course', compact('majors'));
    }

    // public function download($filename)
    // {
    //     $filePath = 'uploads/' . $filename;

    //     if (Storage::disk('public')->exists($filePath)) {
    //         return response()->download(storage_path('app/public/' . $filePath));
    //     } else {
    //         return redirect()->back()->with('error', 'File không tồn tại.');
    //     }
    // }
}
