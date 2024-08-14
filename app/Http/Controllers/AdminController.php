<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    //get all users có usertype = user in database
    public function getUsers()
    {
        // Lấy tất cả người dùng có usertype = 'user'
        $users = User::where('usertype', 'user')->get();
        // lấy tất cả người dùng có usertype = 'lecturer'
        $lecturers = User::where('usertype', 'lecturer')->get();

        return view('admin.user', compact('users', 'lecturers'));
    }
    


    public function manage()
    {
        
        $user = Auth::user();
        if($user->usertype != 'admin'){
            return redirect()->route('admin.dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }

        $lecturers = User::where('usertype', 'lecturer')->get();

        // Truyền biến $lecturers vào view
        return view('admin.manage', compact('lecturers'));
    }

    public function manageLecturer()
    {
        // Chức năng cho lecturer
        return view('admin.lecturer_manage');
    }

    public function toggleLecturerPermission($lecturerId)
    {
        $lecturer = User::find($lecturerId);
    
        if ($lecturer && $lecturer->usertype === 'lecturer') {
            $lecturer->can_manage_content = !$lecturer->can_manage_content;
            $lecturer->save();
        }
    
        return redirect()->back();
    }


}

