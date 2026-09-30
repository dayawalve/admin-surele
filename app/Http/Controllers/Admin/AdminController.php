<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::select('admins.*',);
        if ($request->has('search_name')) {
            $names = explode(' ', $request->search_name, 2);
            $query->where(function ($q) use ($names) {
                foreach ($names as $name) {
                    $q->orWhere('admins.fname', 'like', "%$name%")
                        ->orWhere('admins.lname', 'like', "%$name%");
                }
            });
        }
        if (isset($request->search_email)) {
            $query = $query->Where('admins.email', 'like', '%' . $request->search_email . '%');
        }
        $data = $query->orderBy('admins.id', 'desc')->with('roles')->paginate(10);
        return view('admin.users.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $RoleList = Role::all();
        return view('admin.users.create', compact('RoleList'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:admins|max:255',
        ]);
        $user = new Admin();
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if (isset($request->profile_image)) {
            $Image = time() . '.' . $request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('storage/admin/photo'), $Image);
            $user->photo = 'public/storage/admin/photo/' . $Image;
        }

        if ($user->save()) {
            $role = Role::findOrFail($request->role);
            $user->assignRole($role);
            return redirect()->route('admin.users.index')->with('success', 'Record created successfully.');
        } else {
            return view('admin.users.create')->with('error', 'Something went to wrong, please try again!.');
        }
    }

    public function edit($id)
    {
        $RoleList = Role::all();
        $data = Admin::find($id);
        $roleId = NULL;
        if ($data->roles->first() != NULL) {
            $roleId = $data->roles->first()->id;
        }
        return view('admin.users.edit', compact('data', 'RoleList', 'roleId'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => [
                'email',
                'required',
                Rule::unique('admins')->ignore($id),
            ],
        ]);
        $user = Admin::find($id);
        $roleId = NULL;
        if ($user->roles->first() != NULL) {
            $roleId = $user->roles->first()->id;
        }
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        if (isset($request->profile_image)) {
            $Image = time() . '.' . $request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('storage/admin/photo'), $Image);
            $user->photo = 'public/storage/admin/photo/' . $Image;
        }
        if ($user->save()) {
            $Role = Role::where('id', $request->role)->first();

            if ($roleId != $request->role || $roleId == NULL) {
                if ($roleId != NULL) {
                    $user->removeRole($roleId);
                }
                $user->assignRole($Role->name);
            }
            return redirect()->route('admin.users.index')->with('success', 'Record updated successfully.');
        } else {
            return view('admin.users.edit')->with('error', 'Something went to wrong, please try again!.');
        }
    }

    public function destroy($id)
    {
        $user = Admin::find($id);
        if ($user->is_deleted == 0) {
            $user->is_deleted = 1;
            $msg = 'User deleted successfully';
        } else {
            $user->is_deleted = 0;
            $msg = 'User restore successfully';
        }
        $user->update();
        return redirect()->route('admin.users.index')->with('success', $msg);
    }

    public function VerifyUser(Request $request)
    {
        $user = Admin::find($request->id);
        $user->email_verified_at = now();
        if ($user->update()) {
            return json_encode(['status' => true, 'msg' => 'User Verified']);
        } else {
            return json_encode(['status' => false, 'msg' => 'Something went wrong']);
        }
    }

    public function ChangeStatus($id)
    {
        $user = Admin::find($id);
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'User not found');
        }
        $user->status = $user->status == 1 ? 0 : 1;
        $msg = $user->status == 1 ? 'User has been unblocked' : 'User has been blocked';
        if ($user->update()) {
            return redirect()->route('admin.users.index')->with('success', $msg);
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Something went wrong');
        }
    }
}
