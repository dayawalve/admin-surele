<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Models\Students;
use App\Models\StudentPayment;
use App\Models\TrainingProgram;
use Carbon\Carbon;
use DB;

class ReportsController extends Controller
{

    public function index(Request $request)
    {
        $fromDate = $request->from_date
            ? Carbon::parse($request->from_date)->startOfDay()
            : null;

        $toDate = $request->to_date
            ? Carbon::parse($request->to_date)->endOfDay()
            : null;

        $programId = $request->program_id;

        $paymentQuery = StudentPayment::with(['student', 'trainingProgram']);

        if ($fromDate && $toDate) {
            $paymentQuery->whereBetween('payment_date', [$fromDate, $toDate]);
        }

        if ($programId) {
            $paymentQuery->where('training_program_id', $programId);
        }

        $payments = $paymentQuery
            ->orderBy('payment_date', 'desc')
            ->get();

        $paidAmount = $payments->sum('amount');

        $totalStudents = Students::where('is_deleted', 0)
            ->when($programId, function ($q) use ($programId) {
                $q->where('training_program_id', $programId);
            })
            ->count();

        $totalRevenue = Students::with('trainingProgram')
            ->where('is_deleted', 0)
            ->when($programId, function ($q) use ($programId) {
                $q->where('training_program_id', $programId);
            })
            ->get()
            ->sum(function ($student) {
                return $student->trainingProgram->fees ?? 0;
            });

        $pendingAmount = max($totalRevenue - $paidAmount, 0);

        $programReport = TrainingProgram::where('is_deleted', 0)
            ->withCount([
                'students as students_count' => function ($q) {
                    $q->where('is_deleted', 0);
                }
            ])
            ->get()
            ->map(function ($program) {
                $revenue = StudentPayment::where('training_program_id', $program->id)
                    ->sum('amount');

                $expected = Students::where('training_program_id', $program->id)
                    ->where('is_deleted', 0)
                    ->count() * ($program->fees ?? 0);

                $pending = max($expected - $revenue, 0);

                return (object) [
                    'program_name'   => $program->program_name,
                    'students_count' => $program->students_count,
                    'revenue'        => $revenue,   
                    'pending'        => $pending,   
                ];
            });

        $trainingPrograms = TrainingProgram::where('is_deleted', 0)->get();

        return view('admin.reports.index', compact(
            'payments',
            'totalRevenue',   
            'paidAmount',     
            'pendingAmount',
            'totalStudents',
            'programReport',
            'trainingPrograms'
        ));
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
}
