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
use PhpParser\Node\Stmt\TryCatch;

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
        if (Auth::user()->usertype !== 'lecturer'|| !Auth::user()->can_manage_content) {
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
        try {
            //code...
            $validated = $request->validate([
                'course_id.*' => 'required|exists:courses,id',
                'topic.*' => 'required|string|max:1000',
                'number_of_periods.*' => 'required|integer|min:1',
                'objectives.*' => 'nullable|string',
                'clos' => 'array',
                'clos.*' => 'exists:courses_lo,id',
                'lecture_method.*' => 'nullable|string|max:1000',
                'active.*' => 'nullable|string|max:1000',
                's_download.*' => 'nullable|file|mimes:pdf,png,jpg,doc,docx,ppt,pptx,xls,xlsx,zip'
            ]);

            foreach ($request->course_id as $index => $courseId) {
                $lesson = new Lessons();
                $lesson->course_id = $courseId;
                $lesson->topic = $request->topic[$index];
                $lesson->number_of_periods = $request->number_of_periods[$index];
                $lesson->objectives = $request->objectives[$index];
                $lesson->lecture_method = $request->lecture_method[$index];
                $lesson->active = $request->active[$index];
//                 $lesson->objectives = "- Sinh viên hiểu được mục tiêu, vị trí và vai trò của môn học trong chương trình đào tạo của ngành.";
//                 $lesson->lecture_method = "- Giảng viên giới thiệu đến
// sinh viên mục tiêu môn học;
// vị trí và vai trò của môn học
// trong chương trình đào tạo
// của ngành; chuẩn đầu ra môn
// học, các hình thức kiểm tra
// đánh giá và trọng số của các
// bài đánh giá, nội dung học
// phần theo chương.
// - Giảng bài kết hợp trình chiếu
// slide bài giảng.
// - Đặt câu hỏi cho sinh viên suy
// nghĩ và trả lời.";
//                 $lesson->active = "Học ở lớp: - Nghe giảng. - Trả lời các câu hỏi của giảng viên đưa ra. - Đặt câu hỏi các vấn đề quan tâm. Học ở nhà: - Ôn lại lý thuyết .- Đọc thêm tài liệu, tìm hiểu nội dung bài mới";
                // $lesson->clos()->sync($request->clos[$index]);
                // Xử lý upload file
                if ($request->hasFile('s_download') && isset($request->s_download[$index])) {
                    $file = $request->s_download[$index]; // Lấy file tương ứng với $index
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $file->storeAs('public/uploads', $filename);
                    $lesson->s_download = $filename;
                }
                
        
                $lesson->save();

                $lesson->coursesLo()->sync($request->clos[$index]);
            }

            return redirect()->route('lessons.index')->with('success', 'Lessons created successfully!');
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo lessons' . $e->getMessage());
        }
    }

    



    public function edit(Lessons $lesson)
    {
        if (Auth::user()->usertype !== 'lecturer'|| !Auth::user()->can_manage_content) {
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
            'topic' => 'required|string|max:1000',
            'number_of_periods' => 'required|integer',
            'objectives' => 'nullable|string',
            'clos' => 'nullable|array',
            'lecture_method' => 'nullable|string|max:1000',
            'active' => 'nullable|string|max:1000',
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
        if (Auth::user()->usertype !== 'lecturer'||!Auth::user()->can_manage_content) {
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

    public function download($filename)
    {
        $filePath = 'uploads/' . $filename;

        if (Storage::disk('public')->exists($filePath)) {
            return response()->download(storage_path('app/public/' . $filePath));
        } else {
            return redirect()->back()->with('error', 'File không tồn tại.');
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
