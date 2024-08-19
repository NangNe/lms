<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class MajorController extends Controller
{
    // Hiển thị danh sách chuyên ngành
    public function showMajor()
    {
        // Chỉ cho phép xem nếu user là giảng viên hoặc admin
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        $majors = Major::all();
        return view('admin/major/index', compact('majors'));
    }

    // Tạo chuyên ngành (chỉ dành cho admin)
    public function create()
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'Bạn không có quyền tạo chuyên ngành.');
        }

        return view('admin/major/create');
    }

    // Lưu chuyên ngành mới (chỉ dành cho admin)
    public function store(Request $request)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'Bạn không có quyền lưu chuyên ngành.');
        }

        $request->validate([
            'code' => 'required|string|max:255|unique:majors',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'decision_number' => 'nullable|string',
        ]);

        // Tạo chuyên ngành mới
        $major = Major::create($request->all());

        // Tính tổng số tín chỉ từ bảng courses liên quan đến major_id vừa tạo
        $totalCredits = $major->courses->sum('credits');

        // Cập nhật giá trị total_credits
        $major->total_credits = $totalCredits;
        $major->save();

        return redirect()->route('majors')->with('success', 'Chuyên ngành đã được tạo thành công.');
    }



    // Chỉnh sửa chuyên ngành (chỉ dành cho admin)
    public function edit($id)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'Bạn không có quyền chỉnh sửa chuyên ngành.');
        }

        $major = Major::findOrFail($id);
        return view('admin/major/edit', compact('major'));
    }

    // Cập nhật chuyên ngành (chỉ dành cho admin)
    public function update(Request $request, $id)
    {
        // Kiểm tra quyền truy cập
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'Bạn không có quyền cập nhật chuyên ngành.');
        }

        // Tìm chuyên ngành theo ID
        $major = Major::findOrFail($id);

        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'code' => 'required|string|max:255|unique:majors,code,' . $major->id,
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

        return redirect()->route('majors')->with('success', 'Chuyên ngành đã được cập nhật thành công.');
    }

    // Xóa chuyên ngành (chỉ dành cho admin)
    public function destroy($id)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('majors')->with('error', 'Bạn không có quyền xóa chuyên ngành.');
        }

        $major = Major::find($id);

        if ($major) {
            $major->delete();
            return redirect()->route('majors')->with('success', 'Chuyên Ngành đã được xóa.');
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
        return view('admin/major/courses', compact('majors'));
    }
}
