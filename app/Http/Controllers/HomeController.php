<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\Course;
use App\Models\Assignments;
use App\Models\CoursesLo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Material;

class HomeController extends Controller
{
    //
    public function index()
    {
        $majors = Major::all()->groupBy('code');
        return view('user/index')->with('majors', $majors);
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
        $major = Major::with('plos')->findOrFail($id);
        $ploCount = $major->plos->count();
        $courseCount = $majors->courses->count();
        $creditCount = $majors->courses->sum('credits');
        
        return view('user/course', compact('majors', 'major', 'ploCount', 'courseCount', 'creditCount'));
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $courses = Course::where('name', 'LIKE', "%$query%")
            ->orWhere('code', 'LIKE', "%$query%")
            ->get();

        if (Auth::check()) {
            $userType = Auth::user()->usertype;

            if ($userType === 'admin' || $userType === 'lecturer') {
                // Trả về view cho admin
                return view('admin/courses.search', compact('courses'));
            } elseif ($userType === 'user') {
                // Trả về view cho user thông thường
                return view('user/search', compact('courses'));
            }
        } else {

            return view('guest.search', compact('courses'));
        }
        
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
