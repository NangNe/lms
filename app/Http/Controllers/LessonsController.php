<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lessons;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use App\Models\CoursesLo;
use Illuminate\Support\Facades\Auth;
use ZipArchive;
use Illuminate\Support\Facades\Log;

class LessonsController extends Controller
{
    public function index()

    {
        $user = Auth::user();
        $query = Lessons::query();
        if ($user->usertype === 'lecturer') {
            $courseIds = $user->courses->pluck('id')->toArray();
            $query->whereIn('course_id', $courseIds);
        }
        $lessons = Lessons::with('coursesLo')->get();
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền tạo lessons.');
        }
        $user = Auth::user();
        $courses = Course::all();
        $courselos = CoursesLo::all();
        if ($user->usertype === 'lecturer') {
            $courses = $courses->filter(function ($course) use ($user) {
                return $user->courses->contains($course);
            });
        }

        return view('admin.lessons.create', compact('courses', 'courselos'));
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền của người dùng
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền tạo bài giảng.');
        }

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'clos' => 'array',
            'clos.*' => 'exists:courses_lo,id',
            'topic' => 'required|string|max:255',
            'number_of_periods' => 'required|integer',
            'objectives' => 'required|string',
            'lecture_method' => 'nullable|string',
            'active' => 'nullable|string',
            's_download' => 'nullable|file|mimes:pdf,png,jpg,doc,docx,ppt,pptx,xls,xlsx,zip'
        ]);

        // Kiểm tra khóa học thuộc về giảng viên
        $user = Auth::user();
        if ($user->usertype === 'lecturer') {
            $courseIds = $user->courses->pluck('id')->toArray();
            if (!in_array($request->course_id, $courseIds)) {
                return redirect()->back()->with('error', 'Bạn không thể thêm bài giảng cho khóa học này.');
            }
        }

        // Tạo bài giảng mới
        $lesson = new Lessons();
        $lesson->course_id = $request->course_id;
        $lesson->topic = $request->topic;
        $lesson->number_of_periods = $request->number_of_periods;
        $lesson->objectives = $request->objectives;
        $lesson->clos = $request->clos ? implode(',', $request->clos) : null;
        $lesson->lecture_method = $request->lecture_method;
        $lesson->active = $request->active;

        // Xử lý file đính kèm
        if ($request->hasFile('s_download')) {
            $file = $request->file('s_download');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $lesson->s_download = $filename;
        }

        $lesson->save();
        $lesson->coursesLo()->sync($request->clos);

        return redirect()->route('lessons.index')->with('success', 'Bài giảng đã được tạo thành công.');
    }


    public function edit(Lessons $lesson)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa lessons.');
        }
        $user = Auth::user();
        $lecturerCourse = $user->courses;

        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($lesson->course_id)) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa Lessons này.');
        }
        $selectedCourse = $lesson->course;
        $clos = CoursesLo::where('course_id', $selectedCourse->id)->get(); // Lấy CLOs theo khóa học

        $selectedClos = $lesson->coursesLo->pluck('id')->toArray(); // Lấy các CLO đã được chọn từ bảng trung gian

        return view('admin.lessons.edit', compact('lesson', 'lecturerCourse', 'clos', 'selectedClos'));
    }

    public function update(Request $request, Lessons $lesson)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa lessons.');
        }
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'topic' => 'required|string|max:255',
            'number_of_periods' => 'required|integer',
            'objectives' => 'required|string',
            'clos' => 'nullable|array',
            'lecture_method' => 'nullable|string',
            'active' => 'nullable|string',
            's_download' => 'nullable|file|mimes:pdf,png,jpg,doc,docx,ppt,pptx,xls,xlsx,zip'
        ]);
        $user = Auth::user();

        $lesson->course_id = $request->course_id;
        $lesson->topic = $request->topic;
        $lesson->number_of_periods = $request->number_of_periods;
        $lesson->objectives = $request->objectives;
        $lesson->lecture_method = $request->lecture_method;
        $lesson->active = $request->active;

        // Đồng bộ các CLOs đã chọn
        $lesson->coursesLo()->sync($request->clos);
        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($lesson->course_id)) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa Lessons này.');
        }
        if ($request->hasFile('s_download')) {
            // Xóa file cũ nếu có
            if ($lesson->s_download) {
                Storage::delete('public/uploads/' . $lesson->s_download);
            }
            $file = $request->file('s_download');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $lesson->s_download = $filename;
        }

        $lesson->save();

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson updated successfully.');
    }


    public function destroy(Lessons $lesson)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa lessons.');
        }
        // Xóa file nếu có
        $user = Auth::user();
        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($lesson->course_id)) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa lessons này.');
        }
        if ($lesson->s_download) {
            Storage::delete('public/uploads/' . $lesson->s_download);
        }

        $lesson->delete();
        return redirect()->route('lessons.index')
            ->with('success', 'lesson deleted successfully.');
    }

    public function downloadAll($courseId)
    {
        // Lấy danh sách các bài giảng của môn học được chỉ định
        $lessons = Lessons::where('course_id', $courseId)->get();
        
        if ($lessons->isEmpty()) {
            return redirect()->back()->with('error', 'Không có bài giảng nào cho môn học này.');
        }
        
        // Cập nhật đường dẫn lưu trữ chính xác
        $storagePath = storage_path('app/public/uploads/');
        $zipFileName = 'All lesson files.zip';
        $zipPath = $storagePath . $zipFileName;
    
        // Xóa file zip cũ nếu tồn tại
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $filesAdded = false;
            foreach ($lessons as $lesson) {
                if ($lesson->s_download) {
                    // Cập nhật đường dẫn tệp tin
                    $filePath = $storagePath . $lesson->s_download;
                    Log::info("Checking file path: " . $filePath);
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, basename($filePath));
                        $filesAdded = true;
                    } else {
                        Log::error("File không tồn tại: " . $filePath);
                    }
                }
            }
            $zip->close();
    
            if (!$filesAdded) {
                Log::error("Không có tệp nào được thêm vào ZIP.");
                return redirect()->back()->with('error', 'Không có tệp nào để nén.');
            }
        } else {
            Log::error("Không thể mở hoặc tạo file zip tại: " . $zipPath);
            return redirect()->back()->with('error', 'Không thể tạo file zip.');
        }
    
        if (file_exists($zipPath)) {
            return response()->download($zipPath)->deleteFileAfterSend(true);
        } else {
            return redirect()->back()->with('error', 'File zip không tồn tại hoặc không thể tạo.');
        }
    }
    
    
    


    public function getClos($courseId)
    {
        // Lấy danh sách các CLOs liên quan đến course_id
        $clos = CoursesLo::where('course_id', $courseId)->get();

        // Trả về danh sách CLOs dưới dạng JSON
        return response()->json($clos);
    }

    public function getClosByCourse($courseId)
    {
        $clos = CoursesLo::where('course_id', $courseId)->get();
        return response()->json($clos);
    }
}
