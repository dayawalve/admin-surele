<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AIModelController extends Controller
{
    protected $conn = 'pgsql_second';

    public function index()
    {
        $models = DB::connection($this->conn)
            ->table('ai_models')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.ai-models.index', compact('models'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        return view('admin.ai-models.create');
    }

    public function store(Request $request)
    {
        DB::connection($this->conn)->table('ai_models')->insert([
            'name' => $request->name,
            'max_tokens' => $request->max_tokens ?? 0,
            'input_price' => $request->input_price ?? 0.0,
            'output_price' => $request->output_price ?? 0.0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.ai-models.index')->with('success', 'Model Added');
    }

    public function edit($id)
    {
        $model = DB::connection($this->conn)
            ->table('ai_models')
            ->where('id', $id)
            ->first();

        return view('admin.ai-models.edit', compact('model'));
    }

    public function show($id)
    {
        $model = DB::connection('pgsql_second')
            ->table('ai_models')
            ->where('id', $id)
            ->first();

        return view('admin.ai-models.show', compact('model'));
    }

    public function update(Request $request, $id)
    {
        DB::connection($this->conn)->table('ai_models')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'max_tokens' => $request->max_tokens ?? 0,
                'input_price' => $request->input_price ?? 0.0,
                'output_price' => $request->output_price ?? 0.0,
                'updated_at' => now()
            ]);

        return redirect()->route('admin.ai-models.index')->with('success', 'Model Updated');
    }

    public function destroy($id)
    {
        DB::connection($this->conn)
            ->table('ai_models')
            ->where('id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Model Deleted');
    }
}
