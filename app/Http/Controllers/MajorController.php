<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Plo;

class MajorController extends Controller
{
    // Hiển thị danh sách chuyên ngành
    public function showMajor()
    {
        // Chỉ cho phép xem nếu user là giảng viên hoặc admin
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        $majors = Major::all()->groupBy('code');
    
        // Kiểm tra nếu không có chuyên ngành
        if ($majors->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy chuyên ngành nào.');
        }
    
        return view('admin/major/index', compact('majors'));
    }

    // Tạo chuyên ngành (chỉ dành cho admin)
    public function create()
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'You do not have permission to create a major.');
        }
        $existingCodes = Major::pluck('code')->unique()->toArray();

        return view('admin/major/create', compact('existingCodes'));
    }

    // Lưu chuyên ngành mới (chỉ dành cho admin)
    public function store(Request $request)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'You do not have permission to save the major.');
        }
    
        // Xác thực dữ liệu
        $request->validate([
            'code' => 'required|string|max:255', // Không cần unique
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'decision_number' => 'nullable|string',
        ]);
    
        // Tạo chuyên ngành mới
        $major = Major::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'decision_number' => $request->decision_number,
        ]);
    
        // Tính tổng số tín chỉ từ các khóa học liên quan đến major_id
        $totalCredits = $major->courses->sum('credits');
    
        // Cập nhật giá trị total_credits
        $major->total_credits = $totalCredits;
        $major->save();
    
        return redirect()->route('majors')->with('success', 'Major created successfully.');
    }
    
    

    // Chỉnh sửa chuyên ngành (chỉ dành cho admin)
    public function edit($id)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'You do not have permission to edit the major.');
        }

        $major = Major::findOrFail($id);
        return view('admin/major/edit', compact('major'));
    }

    // Cập nhật chuyên ngành (chỉ dành cho admin)
    public function update(Request $request, $id)
    {
        // Kiểm tra quyền truy cập
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'You do not have permission to update the major.');
        }

        // Tìm chuyên ngành theo ID
        $major = Major::findOrFail($id);

        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'decision_number' => 'nullable|string',
        ]);

        // Cập nhật thông tin chuyên ngành
        $major->update($validatedData);

        // Tính toán tổng tín chỉ từ các khóa học thuộc chuyên ngành này
        $totalCredits = Course::whereHas('majors', function ($query) use ($id) {
            $query->where('majors.id', $id);
        })->sum('credits');

        // Cập nhật tổng tín chỉ
        $major->total_credits = $totalCredits;
        $major->save();

        return redirect()->route('majors')->with('success', 'Major has been updated successfully.');
    }

    // Xóa chuyên ngành (chỉ dành cho admin)
    public function destroy($id)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'You do not have permission to delete the major..');
        }

        $major = Major::find($id);

        if ($major) {
            $major->delete();
            return redirect()->route('majors')->with('success', 'Major has been deleted.');
        }

        return redirect()->route('majors')->with('error', 'Chuyên Ngành không tồn tại.');
    }

    // Hiển thị các khóa học thuộc chuyên ngành
    public function showCourses($id)
    {
        // Giảng viên hoặc admin mới được phép xem
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        $majors = Major::with('courses')->findOrFail($id);
        $major = Major::with('plos')->findOrFail($id);
        $ploCount = $major->plos->count();
        $courseCount = $majors->courses->count();
        $creditCount = $majors->courses->sum('credits');
        
        return view('admin/major/courses', compact('majors', 'major', 'ploCount', 'courseCount', 'creditCount'));
    }
}
