<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinces;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['user'] =  User::whereHas('roles')
                        ->orderByDesc('created_at')->get();
        return view('admin.employee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Provinces::all();
        $roles = Role::query()->get();
        return view('admin.employee.create', compact('provinces','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        if($user){
            $roleIds = $request->roles ? array_map('intval', $request->roles) : [];
            // $roleIds = array_map('intval', $request->roles);
            $user->syncRoles($roleIds);
        }
        return redirect()->route('employee.index')->with('created', 'Thêm nhân viên thành công!');
    }

    public function edit($id)
    {
        $roles = Role::query()->get();
        $user = User::findOrFail($id);
        $provinces = Provinces::all();
        $userHasRole = $user->roles->pluck('id')->toArray();
        foreach ($roles as $item) {
            $item->checked = in_array($item->id, $userHasRole);
        }
        return view('admin.employee.edit', compact('user','provinces', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());
        if($user){
            $roleIds = $request->roles ? array_map('intval', $request->roles) : [];
            $user->syncRoles($roleIds);
        }
        return redirect()->route('employee.index')->with('update', 'Bạn đã cập nhật thành công!');
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