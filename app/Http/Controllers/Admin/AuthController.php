<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAdminRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view("admin.auth.user");
    }

    public function store(LoginAdminRequest $request)
    {
        if(Auth::guard('admin')->attempt($request->validated())){
            $permissions = Auth::guard('admin')->user()->roles;
            if (count($permissions)) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('admin.login.form')->with(['error' => 'Email hoặc mật khẩu không đúng.']);
            }
        } else {
            return redirect()->route('admin.login.form')->with(['error' => 'Email hoặc mật khẩu không đúng.']);
        }

    }

    public function logout()
    {
       Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}