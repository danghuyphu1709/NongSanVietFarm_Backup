<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordAdminRequest;
use App\Models\Provinces;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileAdminRequest;
use App\Models\User;

class ProfileUserController extends Controller
{
    public function profile()
    {

        $provinces = Provinces::query()->get();
        return view('admin.profile.index', compact('provinces'));
    }

    public function update(ProfileAdminRequest $request)
    {
        $user = User::where('id', Auth::guard('admin')->user()->id)->first();
        $user->update($request->validated());
        return redirect()->back()->with('update', 'Cập nhật hồ sơ thành công.');
    }

    public function showChangePasswordForm()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.change_password', compact('user'));
    }

    public function changePassword(ChangePasswordAdminRequest $request)
    {
        $user = User::find(Auth::guard('admin')->user()->id);
        $user->update(['password' => $request->new_password]);

        return redirect()->back()->with('update', 'Đổi mật khẩu thành công.');
    }
}