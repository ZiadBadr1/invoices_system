<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Requests\roles\StoreRequest;
use App\Http\Requests\roles\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;


class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
        $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::orderBy('id', 'DESC')->paginate(5)
        ]);
    }

    public function create()
    {
        return view('admin.roles.create', [
            'permission' => Permission::get()
        ]);
    }

    public function store(StoreRequest $request)
    {
        $attributes = $request->validated();
        $permissions = Permission::whereIn('id', $attributes['permission'])->pluck('id')->all();
        $role = Role::create(['name' => $attributes['name']]);
        $role->syncPermissions($permissions);
        return redirect()->route('admin.roles.index')
            ->with('success', 'تم إنشاء الصلاحية بنجاح.');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(UpdateRequest $request, $id)
    {

        $attributes = $request->validated();
        $role = Role::findOrFail($id);

        $role->update(['name' =>$attributes['name']]);

        $permissions = Permission::whereIn('id',$attributes['permission'])->pluck('id')->all();

        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'تم تحديث الصلاحية بنجاح.');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
