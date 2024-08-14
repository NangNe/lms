<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        

        $user = Auth::user();

        // Cho phép admin truy cập
        if ($user && $user->usertype === 'admin') {
            return $next($request);
        }

        // Cho phép lecturer với quyền quản lý truy cập
        if ($user && $user->usertype === 'lecturer' && $user->can_manage_content) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Bạn không có quyền truy cập vào trang này.');
    }
    
}
