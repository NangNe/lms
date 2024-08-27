<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignments;
use App\Models\Course;
use App\Models\CoursesLo;
use Illuminate\Support\Facades\Auth;

class AssignmentsController extends Controller
{
    //
    public function index()
    {

        $user = Auth::user();
        $query = Assignments::query();

        if ($user->usertype === 'lecturer') {
            // Lấy các khóa học mà giảng viên đang dạy
            $courseIds = $user->courses->pluck('id')->toArray();
            $query->whereIn('course_id', $courseIds);
        }

        $assignments = Assignments::with('coursesLo')->get();
        return view('admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền tạo Assignments.');
        }
        $user = Auth::user();
        $allcourses = Course::all();
        $courselos = CoursesLo::all();

        if ($user->usertype === 'lecturer') {
            // Lọc khóa học cho giảng viên
            $allcourses = $allcourses->filter(function ($course) use ($user) {
                return $user->courses->contains($course);
            });
        }

        return view('admin.assignments.create', compact('allcourses', 'courselos'));
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền của người dùng
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền tạo Assignments.');
        }

        // Xác thực dữ liệu
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'component_name' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'clo_ids' => 'nullable|array',
            'clo_ids.*' => 'nullable|exists:courses_lo,id',
            'assessment_type' => 'nullable|string|max:255',
            'assessment_tool' => 'nullable|string|max:255',
            'clo_weight' => 'nullable|numeric',
            'plos' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Kiểm tra nếu khóa học thuộc về giảng viên
        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($request->course_id)) {
            return redirect()->route('assignments.index')->with('error', 'Bạn không có quyền thêm assignment cho khóa học này.');
        }

        // Tạo mới assignment
        $assignment = Assignments::create([
            'course_id' => $request->course_id,
            'component_name' => $request->component_name,
            'weight' => $request->weight,
            'assessment_type' => $request->assessment_type ?? null,
            'assessment_tool' => $request->assessment_tool ?? null,
            'clo_weight' => $request->clo_weight ?? null,
            'plos' => $request->plos ?? null,
        ]);

        // Liên kết CLOs nếu có
        if ($request->clo_ids && is_array($request->clo_ids)) {
            $assignment->coursesLo()->sync($request->clo_ids);
        }

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment đã được tạo thành công.');
    }



    public function edit(Assignments $assignment)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền sửa lessons.');
        }
        $user = Auth::user();

        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($assignment->course_id)) {
            return redirect()->route('assignments.index')->with('error', 'Bạn không có quyền chỉnh sửa assignment này.');
        }

        $lecturerCourses = $user->courses;
        $selectedCourse = $assignment->course;
        $clos = CoursesLo::where('course_id', $selectedCourse->id)->get(); // Lấy CLOs theo khóa học
        $selectedClos = $assignment->coursesLo->pluck('id')->toArray(); // Lấy danh sách CLOs đã chọn
        return view('admin.assignments.edit', compact('assignment', 'clos', 'selectedClos', 'lecturerCourses'));
    }

    public function update(Request $request, Assignments $assignment)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa lessons.');
        }
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'component_name' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'clo_ids' => 'nullable|array',
            'assessment_type' => 'nullable|string|max:255',
            'assessment_tool' => 'nullable|string|max:255',
            'clo_weight' => 'nullable|numeric',
            'plos' => 'nullable|string',
        ]);

        $user = Auth::user();

        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($request->course_id)) {
            return redirect()->route('assignments.index')->with('error', 'Bạn không có quyền cập nhật assignment này.');
        }

        $assignment->update($request->except('clo_ids'));

        if ($request->clo_ids) {
            $assignment->coursesLo()->sync($request->clo_ids);
        }

        return redirect()->route('assignments.index')
            ->with('success', 'Assignment updated successfully');
    }
    public function destroy(Assignments $assignment)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa assignments.');
        }
        $user = Auth::user();

        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($assignment->course_id)) {
            return redirect()->route('assignments.index')->with('error', 'Bạn không có quyền xóa assignment này.');
        }

        $assignment->delete();
        return redirect()->route('assignments.index')
            ->with('success', 'Assignment deleted successfully');
    }
}
