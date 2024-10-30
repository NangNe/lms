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
        $query = Plo::query();

        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        $allMajors = Major::with('plos')->get();

        $plos = Plo::all(); // Lấy tất cả các bản ghi

        return view('admin.plo.index', compact('plos', 'allMajors'));
    }

    public function create()
    {
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
        $user = Auth::user();
        $allMajors = Major::all(); // Lấy tất cả chuyên ngành
        $plos = Plo::all();

        if ($user->usertype === 'lecturer') {
            // Lọc chỉ những chuyên ngành mà giảng viên liên quan
            $allMajors = $allMajors->filter(function ($major) use ($user) {
                return $user->majors->contains($major);
            });
        }

        return view('admin.plo.create', compact('allMajors', 'plos'));
    }

    // lưu 1 chuyenngnah
    public function store(Request $request)
    {
        // Lấy mảng dữ liệu từ request
        $majorIds = $request->major_id;         // Mảng chứa các ID của chuyên ngành
        $names = $request->name;                // Mảng chứa tên PLO
        $descriptions = $request->description;  // Mảng chứa mô tả PLO
    
        // Kiểm tra nếu các giá trị trong $majorIds là mảng
        foreach ($names as $index => $name) {
            // Lấy các chuyên ngành từ $majorIds
            $selectedMajors = isset($majorIds[$index]) ? (array) $majorIds[$index] : [];
    
            // Duyệt qua các chuyên ngành đã chọn
            foreach ($selectedMajors as $majorId) {
                // Lưu PLO cho từng chuyên ngành
                PLO::create([
                    'major_id' => $majorId,
                    'name' => $name,
                    'description' => $descriptions[$index] ?? null
                ]);
            }
        }
    
        return redirect()->route('plos.index')->with('success', 'PLO đã được lưu thành công!');
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
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
    
        $plo = Plo::findOrFail($id);
        $allMajors = Major::all();
    
        return view('admin.plo.edit', compact('plo', 'allMajors'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
    
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'major_id' => 'required|exists:majors,id', // Kiểm tra major_id có tồn tại trong bảng majors
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'major_id.required' => 'Bạn chưa chọn chuyên ngành.',
            'major_id.exists' => 'Chuyên ngành không tồn tại.',
            'name.required' => 'Tên không được để trống.',
        ]);
    
        // Nếu qua được validate, tiếp tục xử lý lưu dữ liệu
        $plo = Plo::findOrFail($id);
    
        $plo->major_id = $request->input('major_id');
        $plo->name = $request->input('name');
        $plo->description = $request->input('description');
    
        $plo->save();
    
        return redirect()->route('plos.index')->with('success', 'Program Learning Outcomes updated successfully!');
    }
    
    // xóa plo
    public function destroy($id)
    {
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
    
        $plo = Plo::findOrFail($id);
        $plo->delete();
    
        return redirect()->route('plos.index')->with('success', 'Program Learning Outcomes deleted successfully!');
    }

}
