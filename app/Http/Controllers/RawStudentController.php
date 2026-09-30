<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawStudent;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RawStudentsImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class RawStudentController extends Controller
{
    public function index(Request $request)
    {
        $data = RawStudent::all();
        return view('admin.raw-students.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(Request $request)
    {
        return view('admin.raw-students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {

            if (!$request->hasFile('file')) {
                return back()->with('error', 'No file uploaded.');
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/temp');
            $file->move($destinationPath, $fileName);
            $fullPath = $destinationPath . DIRECTORY_SEPARATOR . $fileName;
            if (!file_exists($fullPath)) {
                return back()->with('error', 'Uploaded file not found on server.');
            }
            Excel::import(new RawStudentsImport, $fullPath);
            @unlink($fullPath);

            return redirect()->route('admin.raw-students.index')->with('success', 'Raw students imported successfully.');

        } catch (\Throwable $e) {
            Log::error('Excel Import Error: ' . $e->getMessage());
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = RawStudent::find($id);
        $user->delete();
        return redirect()->route('admin.raw-students.index')->with('success', 'Raw students deleted successfully');
    }

    public function sendTrainingInvite($id)
    {
        $student = RawStudent::findOrFail($id);

        Mail::send('mail-templates.training-invite-static', [
            'student' => $student
        ], function ($mail) use ($student) {
            $mail->to($student->email);
            $mail->subject('Join Aquil Industrial Program – Aquil Techlab');
        });

        $student->update([
            'is_mailsend' => 1
        ]);
        
        return redirect()->route('admin.raw-students.index')->with('success', 'Invitation email sent successfully.');
    }


}

