<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Display a listing of the leads.
     */
    public function index(Request $request)
    {
        $leads = Schema::hasTable('leads')
            ? DB::table('leads')->orderByDesc('id')->paginate(10)
            : collect();

        $totalLeads = Schema::hasTable('leads') ? DB::table('leads')->count() : 0;

        return view('admin.leads.index', compact('leads', 'totalLeads'));
    }
}
