<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plo;
use App\Models\Major;
use Illuminate\Support\Facades\Auth;


//
class PloController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->usertype !== 'lecturer' && $user->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        // Lấy tất cả PLOs và chuyên ngành
        $plos = Plo::with('majors')->get();
        $allMajors = Major::with('plos')->get();

        return view('admin.plo.index', compact('plos', 'allMajors'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->usertype !== 'lecturer' && $user->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        $allMajors = Major::all();

        if ($user->usertype === 'lecturer') {
            $allMajors = $allMajors->filter(function ($major) use ($user) {
                return $user->majors->contains($major);
            });
        }

        return view('admin.plo.create', compact('allMajors'));
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền truy cập của người dùng
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('plos.index')->with('error', 'You do not have permission to add PLO.');
        }
    
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'major_id' => 'required|array',
            'major_id.*' => 'exists:majors,id',
            'name' => 'required|array',
            'name.*' => 'string|max:255',
            'description' => 'nullable|array',
            'description.*' => 'string|nullable',
        ], [
            'major_id.required' => 'Bạn chưa chọn chuyên ngành.',
            'major_id.*.exists' => 'Chuyên ngành không tồn tại.',
            'name.required' => 'Tên PLO không được để trống.',
        ]);
    
        $names = $request->input('name');
        $descriptions = $request->input('description');
        $majorIdsArray = $request->input('major_id');
    
        // Lặp qua từng PLO và lưu vào cơ sở dữ liệu
        foreach ($names as $index => $name) {
            $description = $descriptions[$index] ?? null;
            $majorIds = $majorIdsArray[$index] ?? [];
    
            // Tạo PLO mới
            $plo = Plo::create([
                'name' => $name,
                'description' => $description,
            ]);
    
            // Kiểm tra và lưu vào bảng trung gian
            foreach ($majorIds as $majorId) {
                $plo->majors()->attach($majorId);
            }
        }
    
        return redirect()->route('plos.index')->with('success', 'PLO was created successfully!');
    }
    

    // chọn nhieu chuyen nganh
    // public function store(Request $request)
    // {
    //     // Lấy các dữ liệu từ request
    //     $majorIds = $request->major_id;         // Mảng chứa các ID của chuyên ngành
    //     $names = $request->name;                // Mảng chứa tên PLO
    //     $descriptions = $request->description;  // Mảng chứa mô tả PLO

    //     // Duyệt qua từng chuyên ngành đã chọn
    //     foreach ($majorIds as $majorId) {
    //         // Duyệt qua từng PLO (tên và mô tả)
    //         foreach ($names as $index => $name) {
    //             // Lưu PLO cho chuyên ngành hiện tại
    //             PLO::create([
    //                 'major_id' => $majorId,                // ID chuyên ngành hiện tại
    //                 'name' => $names[$index],              // Tên PLO tương ứng
    //                 'description' => $descriptions[$index] // Mô tả PLO tương ứng
    //             ]);
    //         }
    //     }

    //     return redirect()->route('plos.index')->with('success', 'PLO đã được lưu thành công cho các chuyên ngành đã chọn!');
    // }


    public function edit($id)
    {
        $user = Auth::user();

        if ($user->usertype !== 'lecturer' && $user->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        $plo = Plo::with('majors')->findOrFail($id);
        $allMajors = Major::all();

        return view('admin.plo.edit', compact('plo', 'allMajors'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->usertype !== 'lecturer' && $user->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to update PLO.');
        }

        $validatedData = $request->validate([
            'major_id' => 'required|array',
            'major_id.*' => 'exists:majors,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $plo = Plo::findOrFail($id);

        $plo->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        // Cập nhật các chuyên ngành liên kết
        $plo->majors()->sync($request->input('major_id'));

        return redirect()->route('plos.index')->with('success', 'PLO has been updated successfully!');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to delete PLO.');
        }

        $plo = Plo::findOrFail($id);
        $plo->majors()->detach(); // Xóa liên kết với các chuyên ngành
        $plo->delete();

        return redirect()->route('plos.index')->with('success', 'PLO has been deleted successfully!');
    }
}
