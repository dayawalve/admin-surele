<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IdealTimeReason;
use App\Models\EmployeeDailyActivity;
use Illuminate\Support\Facades\DB;

class IdealTimeReasonController extends Controller
{

    public function index(Request $request)
    {
        $data = IdealTimeReason::with('employee', 'approvedBy')

            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })

            ->when($request->employee_name, function ($query, $name) {
                $query->whereHas('employee', function ($q) use ($name) {
                    $q->where('name', 'like', '%' . $name . '%');
                });
            })

            ->when($request->filter_date, function ($query, $date) {
                $query->whereDate('created_at', $date);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.ideal-time-reasons.index', compact('data'))
            ->with('i', ($data->currentPage() - 1) * $data->perPage());
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }


    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $ideal = IdealTimeReason::findOrFail($id);

            if ($ideal->status === 'approved') {
                return;
            }

            $ideal->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            $employeeDailyActivity = EmployeeDailyActivity::where('employee_id', $ideal->employee_id)
                ->where('activity_date', $ideal->created_at->toDateString())
                ->first();

            if ($employeeDailyActivity) {

                $seconds = $ideal->total_seconds;
                $actualDeduct = min($employeeDailyActivity->idle_seconds, $seconds);
                $employeeDailyActivity->idle_seconds -= $actualDeduct;
                $employeeDailyActivity->active_seconds += $actualDeduct;

                $employeeDailyActivity->save();
            }
        });

        return back()->with('success', 'Ideal time approved successfully.');
    }


    public function reject($id)
    {
        $ideal = IdealTimeReason::findOrFail($id);

        $ideal->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Ideal time rejected.');
    }

}
