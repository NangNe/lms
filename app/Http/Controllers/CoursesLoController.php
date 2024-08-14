<?php

namespace App\Http\Controllers;

use App\Models\CoursesLo;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursesLoController extends Controller
{
    /**
     * Hiển thị danh sách các bản ghi.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $query = CoursesLo::query();

        if ($user->usertype === 'lecturer') {
            $courseIds = $user->courses->pluck('id')->toArray();
            $query->whereIn('course_id', $courseIds);
        }

        $allcourses = CoursesLo::with('course')->get();
        $coursesLo = CoursesLo::all(); // Lấy tất cả các bản ghi
        return view('admin.courses_lo.index', compact('coursesLo', 'allcourses'));
    }


    public function create()
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền tạo CoursesLo.');
        }
        $user = Auth::user();
        $allcourses = Course::all();
        $courses_lo = Course::all(); // Lấy tất cả các khóa học

        if ($user->usertype === 'lecturer') {
            $allcourses = $allcourses->filter(function ($course) use ($user) {
                return $user->courses->contains($course);
            });
        }
        return view('admin.courses_lo.create', compact('allcourses', 'courses_lo'));
    }

    // public function store(Request $request)
    // {
    //     if (Auth::user()->usertype !== 'lecturer') {
    //         return redirect()->back()->with('error', 'Bạn không có quyền tạo CoursesLo.');
    //     }
    //     $data = $request->validate([
    //         'course_id.*' => 'required|exists:courses,id',
    //         'name.*' => 'required|string',
    //         'detail' => 'nullable|string',
    //         'knowledge' => 'nullable|string',
    //         'skills' => 'nullable|string',
    //         'autonomy_responsibility' => 'nullable|string',
    //         // Add validation rules for other fields
    //     ]);

    //     $user = Auth::user();

    //     if ($user->usertype === 'lecturer') {
    //         // Kiểm tra nếu khóa học thuộc về giảng viên
    //         if (!$user->courses->pluck('id')->contains($request->course_id)) {
    //             return redirect()->back()->with('error', 'Bạn không có quyền thêm assignment cho khóa học này.');
    //         }
    //     }


    //     foreach ($data['course_id'] as $index => $course_id) {
    //         CoursesLO::create([
    //             'course_id' => $course_id,
    //             'name' => $data['name'][$index],
    //             'detail' => $request->detail,
    //             'knowledge' => $request->knowledge,
    //             'skills' => $request->skills,
    //             'autonomy_responsibility' => $request->autonomy_responsibility,
    //             // Add other fields
    //         ]);
    //     }


    //     return redirect()->route('courses_lo')->with('success', 'CoursesLo đã được tạo thành công.');
    // }

    public function store(Request $request)
{
    if (Auth::user()->usertype !== 'lecturer') {
        return redirect()->back()->with('error', 'Bạn không có quyền tạo CoursesLo.');
    }
    $course_ids = $request->input('course_id');
    $names = $request->input('name');
    $details = $request->input('detail');
    $knowledges = $request->input('knowledge');
    $skills = $request->input('skills');
    $responsibilities = $request->input('autonomy_responsibility');

    $user = Auth::user();

    // if ($user->usertype === 'lecturer') {
    //     // Kiểm tra nếu khóa học thuộc về giảng viên
    //     if (!$user->courses->pluck('id')->contains($request->course_id)) {
    //         return redirect()->back()->with('error', 'Bạn không có quyền thêm courseLo cho khóa học này.');
    //     }
    // }
    // Đảm bảo rằng tất cả các mảng đều có cùng số lượng phần tử
    $count = count($course_ids);

    for ($i = 0; $i < $count; $i++) {
        $data = [
            'course_id' => $course_ids[$i],
            'name' => $names[$i],
            'detail' => $details[$i],
            'knowledge' => $knowledges[$i],
            'skills' => $skills[$i],
            'autonomy_responsibility' => $responsibilities[$i],
        ];

        // Lưu từng mục một
        CoursesLo::create($data);
    }

    return redirect()->route('courses_lo')->with('success', 'Learning Outcomes saved successfully!');
}

    public function edit($id)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->route('courses_lo')->with('error', 'Bạn không có quyền chỉnh sửa CoursesLo.');
        }
        $user = Auth::user();
        $coursesLo = CoursesLo::findOrfail($id);

        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($coursesLo->course_id)) {
            return redirect()->route('courses_lo')->with('error', 'Bạn không có quyền chỉnh sửa CoursesLo này.');
        }

        $lecturerCourses = $user->courses;
        $currentCourse = $coursesLo->course_id;
        // $allcoursesLo = CoursesLo::all();
        return view('admin.courses_lo.edit', compact('coursesLo', 'currentCourse', 'lecturerCourses'));
    }


    public function update(Request $request, $id)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->route('courses_lo')->with('error', 'Bạn không có quyền chỉnh sửa CoursesLo.');
        }
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'knowledge' => 'nullable|string',
            'skills' => 'nullable|string',
            'autonomy_responsibility' => 'nullable|string',
        ]);

        $user = Auth::user();
        $coursesLo = CoursesLo::findOrfail($id);

        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($coursesLo->course_id)) {
            return redirect()->route('courses_lo')->with('error', 'Bạn không có quyền chỉnh sửa CoursesLo này.');
        }



        $coursesLo->update($request->all());

        return redirect()->route('courses_lo')->with('success', 'CoursesLo đã được cập nhật thành công.');
    }


    public function destroy($id)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->route('courses_lo')->with('error', 'Bạn không có quyền xóa CoursesLo.');
        }
        $user = Auth::user();
        $coursesLo = CoursesLo::findOrFail($id);
        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($coursesLo->course_id)) {
            return redirect()->route('courses_lo')->with('error', 'Bạn không có quyền xóa CoursesLo này.');
        }



        $coursesLo->delete();


        return redirect()->route('courses_lo')->with('success', 'CoursesLo đã được xóa thành công.');
    }

    //     public function getClosByCourse($courseId)
    // {
    //     $clos = CoursesLo::where('course_id', $courseId)->get();
    //     return response()->json($clos);
    // }

}
