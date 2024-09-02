<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinces;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['user'] =  User::whereDoesntHave('roles')
                        ->orderByDesc('created_at')->get();
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Provinces::all();
        $roles = Role::query()->get();
        return view('admin.user.create', compact('provinces','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        return redirect()->route('user.index')->with('created', 'Thêm khách hàng thành công!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $provinces = Provinces::all();
        return view('admin.user.edit', compact('user','provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());
        return redirect()->route('user.index')->with('update', 'Bạn đã cập nhật thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar) {
            $oldImagePath = str_replace(url('storage'), 'public', $user->avatar);
            Storage::delete($oldImagePath);
        }
        $user->delete();
        return response()->json(true);
    }

}