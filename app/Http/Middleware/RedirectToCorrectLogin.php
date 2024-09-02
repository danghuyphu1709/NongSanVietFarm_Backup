<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectToCorrectLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu URL chứa 'admin'
        if ($request->is('admin/*')) {
            $user = Auth::guard('admin')->user();
            
            // Kiểm tra nếu người dùng không đăng nhập
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login.form');
            }
            // Kiểm tra nếu người dùng đã đăng nhập nhưng không có quyền admin
            if ($user && !$user->roles->count()) {
                return redirect()->route('admin.login.form');
            } 
            
        }

        return $next($request);
    }
} 