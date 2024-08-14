<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $query = Material::query();


        if ($user->usertype === 'lecturer') {
            $courseIds = $user->courses->pluck('id')->toArray();
            $query->whereIn('course_id', $courseIds);
        }
        $materials = Material::all();
        $courses = Course::all();

        return view('admin/material/index', compact('materials', 'courses'));
    }

    public function create()
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->route('material')->with('error', 'Bạn không có quyền tạo material.');
        }
        $user = Auth::user();

        $materials = Material::all();
        $allcourses = Course::all();

        if ($user->usertype === 'lecturer') {
            $allcourses = $allcourses->filter(function ($course) use ($user) {
                return $user->courses->contains($course);
            });
        }

        return view('admin/material/create', compact('allcourses', 'materials'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->route('material')->with('error', 'Bạn không có quyền tạo material.');
        }
    
        $request->validate([
            'course_id.*' => 'required|exists:courses,id',
            'description_material.*' => 'required|string|max:255',
            'is_main_material.*' => 'nullable|boolean',
            'isbn.*' => 'nullable|string',
            'is_hard_copy.*' => 'nullable|boolean',
            'is_online.*' => 'nullable|boolean',
            'note.*' => 'nullable|string',
            'author.*' => 'nullable|string',
            'publisher.*' => 'nullable|string',
            'publish_date.*' => 'nullable|date|before:today', // Quy tắc xác thực cho ngày trước ngày hiện tại
            'edition.*' => 'nullable|string',
        ]);
    
        $user = Auth::user();
    
        foreach ($request->course_id as $index => $courseId) {
            if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($courseId)) {
                continue; // Skip if the lecturer doesn't have access to the course
            }
    
            Material::create([
                'course_id' => $courseId,
                'description_material' => $request->description_material[$index],
                'is_main_material' => $request->boolean('is_main_material')[$index] ?? false,
                'isbn' => $request->isbn[$index],
                'is_hard_copy' => $request->boolean('is_hard_copy')[$index] ?? false,
                'is_online' => $request->boolean('is_online')[$index] ?? false,
                'note' => $request->note[$index],
                'author' => $request->author[$index],
                'publisher' => $request->publisher[$index],
                'publish_date' => $request->publish_date[$index],
                'edition' => $request->edition[$index],
            ]);
        }
    
        return redirect()->route('material')->with('success', 'Các Material đã được tạo thành công.');
    }
    

    public function edit($id)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->route('material')->with('error', 'Bạn không có quyền chỉnh sửa material.');
        }
        $user = Auth::user();
        $material = Material::findOrFail($id);
        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($material->course_id)) {
            return redirect()->route('material')->with('error', 'Bạn không có quyền chỉnh sửa Material này.');
        }
        $lecturerCourses = $user->courses;
        $currentCourse = $material->course_id;
        return view('admin/material/edit', compact('material', 'currentCourse', 'lecturerCourses'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->route('material')->with('error', 'Bạn không có quyền chỉnh sửa material.');
        }
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'description_material' => 'required|string|max:255',
            'is_main_material' => 'nullable|boolean',
            'isbn' => 'nullable|string',
            'is_hard_copy' => 'nullable|boolean',
            'is_online' => 'nullable|boolean',
            'note' => 'nullable|string',
            'author' => 'nullable|string',
            'publisher' => 'nullable|string',
            'published_date' => 'nullable|date|before:today', // Quy tắc xác thực cho ngày trước ngày hiện tại
            'edition' => 'nullable|string',
        ]);
        $user = Auth::user();
        $material = Material::findOrFail($id);
        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($material->course_id)) {
            return redirect()->route('material')->with('error', 'Bạn không có quyền chỉnh sửa material này.');
        }

        $material->update([
            'course_id' => $request->course_id,
            'description_material' => $request->description_material,
            'is_main_material' => $request->has('is_main_material'),
            'isbn' => $request->isbn,
            'is_hard_copy' => $request->has('is_hard_copy'),
            'is_online' => $request->has('is_online'),
            'note' => $request->note,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'published_date' => $request->published_date,
            'edition' => $request->edition,
        ]);

        return redirect()->route('material')->with('success', 'Material đã được cập nhật thành công.');
    }

    public function destroy($id)
    {   
        if (Auth::user()->usertype !== 'lecturer') {
            return redirect()->route('material')->with('error', 'Bạn không có quyền xóa material.');
        }
        $user = Auth::user();
        $material = Material::findOrFail($id);
        if ($user->usertype === 'lecturer' && !$user->courses->pluck('id')->contains($material->course_id)) {
            return redirect()->route('material')->with('error', 'Bạn không có quyền xóa material này.');
        }
        $material->delete();

        return redirect()->route('material')->with('success', 'Material đã được xóa thành công.');
    }
}
