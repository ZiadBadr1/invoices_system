<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(5);
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();
        $user = User::create($attributes);

        $user->assignRole($attributes['roles_name']);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $input = $request->all();

        if (empty($input['password'])) {
            $input = Arr::except($input, ['password']);
        }

        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($request->input('roles_name'));

        return redirect()->route('admin.users.index')->with('success', 'تم تعديل بيانات المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}
