<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrainingProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainingProgram::where('is_deleted', 0);

        if ($request->filled('training_mode')) {
            $query->where('training_mode', $request->training_mode);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('id', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        return view('admin.training_programs.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }


    public function create()
    {
        return view('admin.training_programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_code'   => 'nullable|string|max:50|unique:training_programs,program_code',
            'program_name'   => 'required|string|max:150',
            'description'    => 'nullable|string',
            'duration_weeks' => 'required|integer|min:1',
            'training_mode'  => ['required', Rule::in(['Online','Offline','Hybrid', 'Other'])],
            'fees'           => 'nullable|numeric|min:0',
            'status'         => ['required', Rule::in(['Active','Inactive'])],
        ]);

        TrainingProgram::create($request->all());

        return redirect()
            ->route('admin.training-programs.index')
            ->with('success', 'Training program created successfully');
    }

    public function show($id)
    {
        $data = TrainingProgram::withCount([
            'students as students_count'
        ])->findOrFail($id);

        return view('admin.training_programs.show', compact('data'));
    }

    public function edit($id)
    {
        $data = TrainingProgram::findOrFail($id);

        return view('admin.training_programs.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = TrainingProgram::findOrFail($id);

        $request->validate([
            'program_code'   => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('training_programs', 'program_code')->ignore($data->id)
            ],
            'program_name'   => 'required|string|max:150',
            'description'    => 'nullable|string',
            'duration_weeks' => 'required|integer|min:1',
            'training_mode'  => ['required', Rule::in(['Online','Offline','Hybrid', 'Other'])],
            'fees'           => 'nullable|numeric|min:0',
            'status'         => ['required', Rule::in(['Active','Inactive'])],
        ]);

        $data->update($request->all());

        return redirect()
            ->route('admin.training-programs.index')
            ->with('success', 'Training program updated successfully');
    }

    public function destroy($id)
    {
        $user = TrainingProgram::find($id);
        if ($user->is_deleted == 0) {
            $user->is_deleted = 1;
            $msg = 'Training program deleted successfully';
        } else {
            $user->is_deleted = 0;
            $msg = 'Training program restore successfully';
        }
        $user->update();
        return redirect()->route('admin.training-programs.index')->with('success', $msg);
    }

    public function status($id)
    {
        $data = TrainingProgram::findOrFail($id);
        $data->status = ($data->status === 'Active') ? 'Inactive' : 'Active';
        $data->save();

        $message = $data->status === 'Active' ? 'Training program activated successfully.'
            : 'Training program deactivated successfully.';

        return redirect()
            ->route('admin.training-programs.index')
            ->with('success', $message);
    }

}
