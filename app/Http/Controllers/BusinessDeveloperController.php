<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessDeveloper;
use Spatie\Permission\Models\Role;



class BusinessDeveloperController extends Controller
{
    public function index(Request $request)
    {
        $query = BusinessDeveloper::withCount('students');

        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        $data = $query->orderBy('students_count', 'DESC')->get();
        $roles = Role::pluck('name', 'id');
        $data = $data->map(function ($bd) use ($roles) {
            $bd->role_name = $roles[$bd->role_id] ?? '-';
            return $bd;
        });

        $topBdId = $data->first()->id ?? null;

        return view(
            'admin.business-developers.index',
            compact('data', 'topBdId')
        )->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $RoleList = Role::all();
        return view('admin.business-developers.create', compact('RoleList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:business_developers,email',
            'phone' => 'nullable|string|max:20',
            'extra_emails.*' => 'nullable|email'
        ]);

        $extraEmails = array_filter($request->extra_emails ?? []);

        $bd = new BusinessDeveloper();
        $bd->name = $request->name;
        $bd->email = $request->email;
        $bd->phone = $request->phone;
        $bd->role_id = $request->role_id;
        $bd->is_active = 1;

        $bd->extra_emails = json_encode($extraEmails);

        $bd->save();

        return redirect()
            ->route('admin.business-developers.index')
            ->with('success', 'Business Developer added successfully');
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = BusinessDeveloper::findOrFail($id);
        $extraEmails = json_decode($data->extra_emails ?? '[]', true);
        $RoleList = Role::all();
        $roleId = $data->role_id;
        return view('admin.business-developers.edit', compact('data', 'RoleList', 'roleId', 'extraEmails'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:business_developers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'extra_emails.*' => 'nullable|email'
        ]);

        $bd = BusinessDeveloper::findOrFail($id);

        $bd->name = $request->name;
        $bd->email = $request->email;
        $bd->phone = $request->phone;
        $bd->role_id = $request->role_id;
        $extraEmails = array_filter($request->extra_emails ?? []);
        $bd->extra_emails = json_encode($extraEmails);
        $bd->save();

        return redirect()
            ->route('admin.business-developers.index')
            ->with('success', 'Business Developer updated successfully');
    }

    public function destroy(string $id)
    {
        $bd = BusinessDeveloper::findOrFail($id);
        $bd->delete();

        return redirect()->route('admin.business-developers.index')->with('success', 'Business Developer deleted successfully');
    }

    public function status(string $id)
    {
        $bd = BusinessDeveloper::findOrFail($id);
        $bd->is_active = !$bd->is_active;
        $bd->save();

        return redirect()->route('admin.business-developers.index')->with('success', 'Status updated successfully');
    }
}
