<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class LecturerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Nếu là admin, cho phép truy cập vào tất cả các route admin
        if ($user && $user->usertype === 'admin') {
            return $next($request);
        }

        // Nếu là giảng viên, chỉ cho phép truy cập vào các khóa học mà họ dạy
        if ($user && $user->usertype === 'lecturer') {

            // // Chỉ cho phép phương thức GET
            // if (!$request->isMethod('get')) {
            //     return redirect('/majors')->with('error', 'Bạn không có quyền thực hiện thao tác này.');
            // }
            // Kiểm tra xem khóa học có phải là của giảng viên này không
            $courseId = $request->route('course_id'); // Lấy ID khóa học từ route nếu có
            if ($courseId && !$user->courses->contains($courseId)) {
                return redirect('/dashboard')->with('error', 'Bạn không có quyền truy cập vào khóa học này.');
            }

            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
    }
}
