<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        $Role = Role::paginate(10);
        $Permissions = Permission::with('roles')->get();
        return view('admin.role-permission.index',compact('Role','Permissions'));
    }

    public function create()
    {
        return view('admin.role-permission.create');
    }

    public function store(Request $request)
    {
        if (!isset($request->role)) {
            return redirect()->back()->with('error','Role not be null');
        }
        if (Role::where('name', $request->role)->exists()) {
            return redirect()->back()->with('error','Role already exits');
        }
        $role = Role::create(['name' => $request->role]);
        return redirect()->route('admin.role-permission.index')->with('success','Role created successfully');
    }

    public function edit(Request $request,$id)
    {   
        $Roles = Role::find($id);
        $rolePermission = $Roles->permissions;
        $PermissionArray[] = NULL;
        if ($rolePermission->first()!=NULL) {
            $PermissionArray = $rolePermission->pluck('id')->toArray();
        }
        $AllPermission = Permission::whereNotNull('controller')->select('controller')
        ->selectRaw("CONCAT('[', GROUP_CONCAT(CASE WHEN permissions.controller IS NOT NULL THEN JSON_OBJECT('id',permissions.id,'name',permissions.name) END), ']') AS permission")
        ->groupBy('permissions.controller')
        ->get();
        return view('admin.role-permission.edit',compact('AllPermission','Roles','PermissionArray',));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->RoleName;
        if ($role->save()) {
            $ReqPermission = $request->permission;
            if (!isset($ReqPermission)) {
                $ReqPermission[] = NULL;
            }
            $permissions = Permission::whereIn('id', $ReqPermission)->get();
            $role->syncPermissions($permissions);
            return redirect()->route('admin.role-permission.index')->with('success','Record has been updated');
        } else {
            return redirect()->route('admin.role-permission.create')->with('error','Something went wrong');
        }
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->syncPermissions([]);
        $role->delete();
        return redirect()->back()->with('success', 'Role and its permissions deleted successfully.');
    }
}
