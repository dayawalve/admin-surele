<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Permission::orderBy('permissions.controller', 'desc');
        if (isset($request->search_controller)) {
            $query = $query->Where('permissions.controller', 'like', '%' . $request->search_controller . '%');
        }
        $data = $query->paginate(10);
        return view('admin.permission-listing.index',compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $RoleList = Role::all();
        return view('admin.permission-listing.create',compact('RoleList'));
    }

    public function store(Request $request)
    {
        try {
            if (isset($request->resource) && $request->resource == 'on') {
                $resource = [
                    $request->permission_name . '.index',
                    $request->permission_name . '.create',
                    $request->permission_name . '.store',
                    $request->permission_name . '.edit',
                    $request->permission_name . '.update',
                    $request->permission_name . '.destroy',
                    $request->permission_name . '.show',
                ];

                foreach ($resource as $value) {
                    $Res_permission = new Permission();
                    $Res_permission->name = $value;
                    $Res_permission->controller = $request->controller_name;
                    $Res_permission->guard_name = 'admin'; 
                    $Res_permission->save();

                    $roles = Role::whereIn('id', $request->roles)
                        ->pluck('name')
                        ->toArray(); 
                    $Res_permission->syncRoles($roles);
                }

                return redirect()->route('admin.permission-listing.index')->with('success', 'Record has been updated');
            } else {
                $permission = new Permission();
                $permission->name = $request->permission_name;
                $permission->controller = $request->controller_name;
                $permission->guard_name = 'admin';

                if ($permission->save()) {
                    $roles = Role::whereIn('id', $request->roles)
                        ->pluck('name')
                        ->toArray(); 
                    $permission->syncRoles($roles);

                    return redirect()->route('admin.permission-listing.index')->with('success', 'Record has been updated');
                } else {
                    return redirect()->route('admin.permission-listing.create')->with('error', 'Something went wrong');
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->route('admin.permission-listing.create')->with('error', 'Dont insert duplicate Permission');
        }
    }

    public function edit($id)
    {
        $data = Permission::find($id);
        return view('admin.permission-listing.edit',compact('data'));

    }

    public function update(Request $request, $id)
    {
        $data = Permission::find($id);
        $data->controller = $request->controller;
        $data->name = $request->name;
        if ($data->save()) {
            return redirect()->route('admin.permission-listing.index')->with('success','Record updated successfully.');
        }else{
            return redirect()->route('admin.permission-listing.edit',$id)->with('error','Something went to wrong, please try again!.');
        }
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->back()->with('success', 'Permissions deleted successfully.');
    }
}
