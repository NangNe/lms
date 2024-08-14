<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Models\CoursesLo;
use App\Models\Material;
use App\Models\Assignments;
use App\Models\Lessons;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {   
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
        $courses = Course::with('majors')->get(); // Lấy tất cả khóa học cùng với thông tin chuyên ngành
        // $prerequisiteIds = json_decode($courses->prerequisites);
        // $prerequisiteCourses = Course::whereIn('id', $prerequisiteIds)->pluck('name');

        return view('admin/courses.index', compact('courses'));
    }

    public function create()
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('courses')->with('error', 'Bạn không có quyền tạo khóa học.');
        }
        $lecturers = User::where('usertype', 'lecturer')->get();
        $majors = Major::all(); // Lấy tất cả chuyên ngành để chọn
        $all_courses = Course::all();
        return view('admin/courses.create', compact('majors', 'all_courses', 'lecturers'));
    }
    public function store(Request $request)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('courses')->with('error', 'Bạn không có quyền lưu khóa học.');
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'lecturers' => 'nullable|array',
            'lecturers.*' => 'exists:users,id',
            'semester' => 'nullable|string|max:255',
            'credits' => 'nullable|integer',
            'prerequisites' => 'nullable|exists:courses,id',
            'prior_course' => 'nullable|exists:courses,id',
            'co_requisite' => 'nullable|exists:courses,id',
            'major_ids' => 'required|array',
            'major_ids.*' => 'exists:majors,id',
            'is_mandatory' => 'boolean',
            'knowledge_area' => 'nullable|in:General,Core,Specialized,Internship,Thesis',
            'objectives' => 'nullable|string',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'student_tasks' => 'nullable|string',
            'decision_no' => 'nullable|string',
            'is_approved' => 'boolean',
            'note' => 'nullable|string',
            'approved_date' => 'nullable|date',
            'is_active' => 'boolean',
            'english_name' => 'nullable|string',
            'time_allocation' => 'nullable|string',
            // 'main_instructor' => 'nullable|string',
            // 'co_instructors' => 'nullable|string',
            'department' => 'nullable|string',
            'syllabus' => 'nullable|mimes:pdf,doc,docx|max:2048', // Validate file syllabus



        ]);

        // $course = Course::create([
        //     'name' => $request->name,
        //     'code' => $request->code,
        //     'semester' => $request->semester,
        //     'credits' => $request->credits,
        //     'prerequisites' => $request->prerequisites,
        //     'prior_course' => $request->prior_course,
        //     'co_requisite' => $request->co_requisite,
        //     'is_mandatory' => $request->has('is_mandatory'),
        //     'knowledge_area' => $request->knowledge_area,
        //     'objectives' => $request->objectives,
        //     'summary' => $request->summary,
        //     'description' => $request->description,
        //     'student_tasks' => $request->student_tasks,
        //     'decision_no' => $request->decision_no,
        //     'is_approved' => $request->has('is_approved'),
        //     'note' => $request->note,
        //     'approved_date' => $request->approved_date,
        //     'is_active' => $request->has('is_active'),
        //     'english_name' => $request->english_name,
        //     'time_allocation' => $request->time_allocation,
        //     // 'main_instructor' => $request->main_instructor,
        //     // 'co_instructors' => $request->co_instructors,
        //     'department' => $request->department,
            

        // ]);
        $course = Course::create($validatedData);

        
        if ($request->hasFile('syllabus')) {
            $file = $request->file('syllabus');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $course->syllabus = $filename;
            $course -> save();
        }

        if ($request->lecturers) {
            $course->lecturers()->sync($request->lecturers);
        
        // Liên kết khóa học với các chuyên ngành
        $course->majors()->attach($request->major_ids);
        return redirect()->route('courses')->with('success', 'Khóa học đã được tạo thành công.');
    }
}


    
    


    public function edit($id)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('courses')->with('error', 'Bạn không có quyền chỉnh sửa khóa học.');
        }
        // Lấy thông tin khóa học và danh sách các chuyên ngành
        $course = Course::findOrFail($id);
        $majors = Major::all();
        $all_courses = Course::all();
        $selectedMajorIds = $course->majors->pluck('id')->toArray();
        $currentPrerequisite = $course->prerequisites;
        $currentPriorCourse = $course->prior_course;
        $currentCoRequisite = $course->co_requisite;
        $lecturers = User::where('usertype', 'lecturer')->get();
        $selectedLecturers = $course->lecturers()->pluck('users.id')->toArray();
    
        return view('admin/courses.edit', compact('course', 'majors', 'all_courses', 'selectedMajorIds', 'currentPrerequisite', 'currentPriorCourse', 'currentCoRequisite', 'lecturers', 'selectedLecturers'));
    }

    // Cập nhật thông tin khóa học vào cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('courses')->with('error', 'Bạn không có quyền cập nhật khóa học.');
        }
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'major_ids' => 'required|array',
            'major_ids.*' => 'exists:majors,id',
            'lecturers' => 'nullable|array',
            'lecturers.*' => 'exists:users,id',
            'semester' => 'nullable|string|max:255',
            'credits' => 'nullable|integer',
            'prerequisites' => 'nullable|string',
            'prior_course' => 'nullable|exists:courses,id',
            'co_requisite' => 'nullable|exists:courses,id',
            'major_ids' => 'required|array',
            'major_ids.*' => 'exists:majors,id',
            'is_mandatory' => 'boolean',
            'knowledge_area' => 'nullable|in:General,Core,Specialized,Internship,Thesis',
            'objectives' => 'nullable|string',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'student_tasks' => 'nullable|string',
            'decision_no' => 'nullable|string',
            'is_approved' => 'boolean',
            'note' => 'nullable|string',
            'approved_date' => 'nullable|date',
            'is_active' => 'boolean',
            'english_name' => 'nullable|string',
            'time_allocation' => 'nullable|string',
            // 'main_instructor' => 'nullable|string',
            // 'co_instructors' => 'nullable|string',
            'department' => 'nullable|string',
            'syllabus' => 'nullable|mimes:pdf,doc,docx|max:2048', // Validate file syllabus



        ]);

        $course = Course::findOrFail($id);
        $course->update([
            'code' => $request->code,
            'name' => $request->name,
            'semester' => $request->semester,
            'credits' => $request->credits,
            'prerequisites' => $request->prerequisites,
            'prior_course' => $request->prior_course,
            'co_requisite' => $request->co_requisite,
            'is_mandatory' => $request->has('is_mandatory'),
            'knowledge_area' => $request->knowledge_area,
            'objectives' => $request->objectives,
            'summary' => $request->summary,
            'description' => $request->description,
            'student_tasks' => $request->student_tasks,
            'decision_no' => $request->decision_no,
            'is_approved' => $request->has('is_approved'),
            'note' => $request->note,
            'approved_date' => $request->approved_date,
            'is_active' => $request->has('is_active'),
            'english_name' => $request->english_name,
            'time_allocation' => $request->time_allocation,
            // 'main_instructor' => $request->main_instructor,
            // 'co_instructors' => $request->co_instructors,
            'department' => $request->department,
        ]);
        $course->majors()->sync($request->major_ids);
        if ($request->lecturers) {
            $course->lecturers()->sync($request->lecturers);
        } else {
            $course->lecturers()->detach();
        }

        return redirect()->route('courses')->with('success', 'Khóa học đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('courses')->with('error', 'Bạn không có quyền xóa khóa học.');
        }
        $course = Course::find($id);

        if ($course) {
            $course->delete();
            return redirect()->route('courses')->with('success', 'Khóa học đã được xóa thành công.');
        } else {
            return redirect()->route('courses')->with('error', 'Khóa học không tồn tại.');
        }
    }

    // Hiển thị danh sách khóa học theo chuyên ngành
    public function show_by_id($id)
    {
        $major = Major::findOrFail($id);
        $courses = $major->courses;
        return view('admin/courses.index', compact('courses'));
    }

    public function showDetail($id)
    {
        $courses = Course::findOrFail($id);
        $coursesLo = CoursesLo::where('course_id', $id)->get();
        $materials = Material::where('course_id', $id)->get();
        $assignments = Assignments::where('course_id', $id)->get();
        $lessons = Lessons::where('course_id', $id)->get();

        return view('admin/courses.detail', compact('courses', 'coursesLo', 'materials', 'assignments', 'lessons'));
    }
    public function getCourseClos($courseId)
{
    $clos = CoursesLo::where('course_id', $courseId)->get(['id', 'name','detail']);
    return response()->json($clos);
}
}
