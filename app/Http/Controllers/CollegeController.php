<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{

    public function index()
    {
        $data = College::get();
        return view('admin.colleges.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }


    public function create()
    {
        $data = College::where('is_active', 1)->where('is_deleted', 0)->get();
        return view('admin.colleges.create', compact('data'));
    }


    public function store(Request $request)
    {
        $user = new College();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->code = $request->code;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;

        // if (isset($request->image)) {
        //     $Image = time() . '.' . $request->image->getClientOriginalExtension();
        //     $request->image->move(public_path('storage/students/photo'), $Image);
        //     $user->image = 'public/storage/students/photo/' . $Image;
        // }

        if ($user->save()) {
            return redirect()->route('admin.colleges.index')->with('success', 'Record created successfully.');
        } else {
            return view('admin.colleges.create')->with('error', 'Something went to wrong, please try again!.');
        }
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $data = College::find($id);
        $college = College::where('is_active', 1)->where('is_deleted', 0)->get();
        return view('admin.colleges.edit', compact('data', 'college'));
    }


    public function update(Request $request, $id)
    {
        $user = College::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->code = $request->code;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;

        // if ($request->hasFile('image')) {

        //     if (!empty($user->image) && file_exists(public_path($user->image))) {
        //         unlink(public_path($user->image));
        //     }
        //     $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        //     $request->image->move(public_path('storage/students/photo'), $imageName);
        //     $user->image = 'public/storage/students/photo/' . $imageName;
        // }

        if ($user->save()) {
            return redirect()
                ->route('admin.colleges.index')
                ->with('success', 'Record updated successfully.');
        }

        return redirect()
            ->back()
            ->with('error', 'Something went wrong, please try again.');
    }


    public function destroy($id)
    {
        $user = College::find($id);
        if ($user->is_deleted == 0) {
            $user->is_deleted = 1;
            $msg = 'Students deleted successfully';
        } else {
            $user->is_deleted = 0;
            $msg = 'Students restore successfully';
        }
        $user->update();
        return redirect()->route('admin.colleges.index')->with('success', $msg);
    }

    public function status($id)
    {
        $college = College::findOrFail($id);

        $college->is_active = $college->is_active == 1 ? 0 : 1;
        $college->save();

        $message = $college->is_active
            ? 'College activated successfully.'
            : 'College deactivated successfully.';

        return redirect()
            ->route('admin.colleges.index')
            ->with('success', $message);
    }

}
