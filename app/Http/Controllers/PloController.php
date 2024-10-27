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
    public function store(Request $request)
    {
        if (Auth::user()->usertype !== 'lecturer' && Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
    
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'major_id.*' => 'required|exists:majors,id', // Kiểm tra major_id có tồn tại trong bảng majors
            'name.*' => 'required|string|max:255',
            'description.*' => 'nullable|string',
        ], [
            'major_id.*.required' => 'Bạn chưa chọn chuyên ngành.',
            'major_id.*.exists' => 'Chuyên ngành không tồn tại.',
            'name.*.required' => 'Tên không được để trống.',
        ]);
    
        // Nếu qua được validate, tiếp tục xử lý lưu dữ liệu
        $major_ids = $request->input('major_id');
        $names = $request->input('name');
        $descriptions = $request->input('description');
    
        $count = count($major_ids);
    
        for ($i = 0; $i < $count; $i++) {
            $data = [
                'major_id' => $major_ids[$i],
                'name' => $names[$i],
                'description' => $descriptions[$i],
            ];
    
            Plo::create($data);
        }
    
        return redirect()->route('plos.index')->with('success', 'Program Learning Outcomes saved successfully!');
    }

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
