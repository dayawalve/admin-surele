<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentPayment;


class StudentsPaymentController extends Controller
{

    public function index(Request $request)
    {
        $data = StudentPayment::with(['student', 'trainingProgram'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.students-payment.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
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
