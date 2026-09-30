<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Screenshot;
use App\Models\TrackingData;
use App\Models\Domain;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeDailyActivity;
use App\Models\EmployeeDomainAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeActivityExport;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $data = Employee::where('is_deleted', 0)->orderBy('id', 'desc')->get();
        return view('admin.employees.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_code'   => 'required|unique:employees,employee_code',
            'name'            => 'required|string|max:255',
            'password'        => 'required',
            'phone'           => 'required|string|max:20',
            'email'           => 'required|email|unique:employees,email',
            'department'      => 'required|string|max:100',
            'designation'     => 'required|string|max:100',
            'salary'          => 'required|numeric|min:0',
            'date_of_birth'   => 'required|date',
            'date_of_joining' => 'required|date',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $student = new Employee();
        $student->employee_code   = $request->employee_code;
        $student->name            = $request->name;
        if (!empty($request->password)) {
            $student->password = Hash::make($request->password);
        }
        $student->phone           = $request->phone;
        $student->email           = $request->email;
        $student->department      = $request->department;
        $student->designation     = $request->designation;
        $student->salary          = $request->salary;
        $student->date_of_birth   = $request->date_of_birth;
        $student->date_of_joining = $request->date_of_joining;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('storage/employees/photo'), $imageName);
            $student->image = 'public/storage/employees/photo/' . $imageName;
        }

        $student->save();

        $plainPassword = $request->password;

        Mail::send('mail-templates.onboard', compact('student', 'plainPassword'),
            function ($message) use ($student) {
                $message->to($student->email);
                $message->subject('Welcome to Surele Task Manager');
            }
        );

        return redirect()->route('admin.employees.index')->with('success', 'Employee added successfully!');
    }


    public function show(Request $request, Employee $employee)
    {
        $data = $employee;

        $selectedDate = $request->get('date', Carbon::today()->toDateString());
        
        $screenshots = Screenshot::where('employee_id', $employee->id)
            ->whereDate('date_time', $selectedDate)
            ->orderBy('date_time', 'desc')
            ->paginate(18);

        $TrackingData = TrackingData::where('employee_id', $employee->id)
            ->whereDate('date_time', $selectedDate)
            ->orderBy('date_time', 'desc')
            ->paginate(50)
            ->withQueryString();

        $dailyActivity = EmployeeDailyActivity::where('employee_id', $employee->id)
            ->where('activity_date', $selectedDate)
            ->first();

        $totalTime = $dailyActivity
            ? $this->formatSeconds($dailyActivity->total_seconds)
            : '0h 0m';

        $activeTime = $dailyActivity
            ? $this->formatSeconds($dailyActivity->active_seconds)
            : '0h 0m';

        $idleTime = $dailyActivity
            ? $this->formatSeconds($dailyActivity->idle_seconds)
            : '0h 0m';

        $topApp = 'N/A';

        $todayTracking = TrackingData::where('employee_id', $employee->id)
            ->whereDate('date_time', $selectedDate)
            ->get();

        if ($todayTracking->count()) {
            $appTimes = $todayTracking
                ->groupBy('active_tabs')
                ->map(fn ($rows) => $rows->sum('active_tabs_time'))
                ->toArray();

            arsort($appTimes);
            $topApp = array_key_first($appTimes);
        }

        $domains = Domain::select(
            'domains.id',
            'domains.name',
            'employee_domain_access.is_enabled'
        )
        ->leftJoin('employee_domain_access', function ($join) use ($employee) {
            $join->on('domains.id', '=', 'employee_domain_access.domain_id')
                ->where('employee_domain_access.employee_id', $employee->id);
        })
        ->orderBy('domains.name')
        ->get();


        $appUsage = [];

        $trackingForDay = TrackingData::where('employee_id', $employee->id)
            ->whereDate('date_time', $selectedDate ?? now()->toDateString())
            ->get();

        if ($trackingForDay->count()) {
            $appUsage = $trackingForDay
                ->groupBy('active_tabs')
                ->map(function ($rows) {
                    return $rows->sum('active_tabs_time');
                })
                ->sortDesc();
        }
        
        return view('admin.employees.show', compact(
            'data',
            'screenshots',
            'TrackingData',
            'totalTime',
            'activeTime',
            'idleTime',
            'topApp',
            'domains',
            'selectedDate',
            'appUsage'
        ));
    }

    private function formatSeconds($seconds)
    {
        if (!$seconds || $seconds < 0) {
            return '0h 0m';
        }

        $hours   = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return "{$hours}h {$minutes}m";
    }

    public function edit($id)
    {
        $data = Employee::find($id);
        return view('admin.employees.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $student = Employee::findOrFail($id);

        $request->validate([
            'employee_code'   => 'required|unique:employees,employee_code,' . $student->id,
            'name'            => 'required|string|max:255',
            // 'password'        => 'required',
            'phone'           => 'required|string|max:20',
            'email'           => 'required|email|unique:employees,email,' . $student->id,
            'department'      => 'required|string|max:100',
            'designation'     => 'required|string|max:100',
            'salary'          => 'required|numeric|min:0',
            'date_of_birth'   => 'required|date',
            'date_of_joining' => 'required|date',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $student->employee_code   = $request->employee_code;
        $student->name            = $request->name;
        if (!empty($request->password)) {
            $student->password = Hash::make($request->password);
        }
        $student->phone           = $request->phone;
        $student->email           = $request->email;
        $student->department      = $request->department;
        $student->designation     = $request->designation;
        $student->salary          = $request->salary;
        $student->date_of_birth   = $request->date_of_birth;
        $student->date_of_joining = $request->date_of_joining;

        if ($request->hasFile('image')) {

            if ($student->image && file_exists(public_path(str_replace('public/', '', $student->image)))) {
                unlink(public_path(str_replace('public/', '', $student->image)));
            }

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('storage/employees/photo'), $imageName);
            $student->image = 'public/storage/employees/photo/' . $imageName;
        }

        $student->save();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        try {

            $employee->delete();

            return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully!');

        } catch (\Throwable $e) {

            return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Failed to delete employee!');
        }
    }

    public function status($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = ($employee->status === 'active') ? 'inactive' : 'active';
        $employee->save();
        $message = ($employee->status === 'active') ? 'Employee activated successfully.' : 'Employee deactivated successfully.';

        return redirect()->route('admin.employees.index')->with('success', $message);
    }

    public function toggle(Request $request, $domainId)
    {
        $employeeId = $request->employee_id;

        if (!$employeeId) {
            return back()->with('error', 'Employee not specified');
        }

        $access = EmployeeDomainAccess::where('employee_id', $employeeId)
            ->where('domain_id', $domainId)
            ->first();

        if ($access) {
            $access->is_enabled = $access->is_enabled == 1 ? 0 : 1;
            $access->save();
        } else {
            EmployeeDomainAccess::create([
                'employee_id' => $employeeId,
                'domain_id'   => $domainId,
                'is_enabled'  => 1,
            ]);
        }

        return back()->with('success', 'Domain access updated successfully');
    }


    public function export(Request $request, $employee)
    {
        $date = $request->get('date', Carbon::today()->toDateString());

        return Excel::download(
            new EmployeeActivityExport($employee, $date),
            "employee_{$employee}_activity_{$date}.xlsx"
        );
    }

}
