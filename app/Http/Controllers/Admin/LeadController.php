<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Get the active leads table name.
     */
    protected function getTableName(): string
    {
        if (Schema::hasTable('enquiries')) {
            return 'enquiries';
        }
        return 'leads';
    }

    /**
     * Display a listing of the leads / enquiries.
     */
    public function index(Request $request)
    {
        $table = $this->getTableName();

        if (!Schema::hasTable($table)) {
            return view('admin.leads.index', [
                'leads'      => collect(),
                'totalLeads' => 0,
                'newLeads'   => 0,
                'todayLeads' => 0,
            ]);
        }

        $query = DB::table($table);

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('product', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $totalLeads = DB::table($table)->count();
        $newLeads   = DB::table($table)->where('status', 'New')->count();
        $todayLeads = DB::table($table)->whereDate('created_at', now()->today())->count();

        $leads = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('admin.leads.index', compact('leads', 'totalLeads', 'newLeads', 'todayLeads'));
    }

    /**
     * Display the specified lead details (JSON or view).
     */
    public function show($id)
    {
        $table = $this->getTableName();
        $lead = DB::table($table)->where('id', $id)->first();

        if (!$lead) {
            if (request()->wantsJson()) {
                return response()->json(['status' => false, 'message' => 'Lead not found.'], 404);
            }
            return back()->with('error', 'Lead not found.');
        }

        if (request()->wantsJson()) {
            return response()->json(['status' => true, 'data' => $lead]);
        }

        return view('admin.leads.show', compact('lead'));
    }

    /**
     * Update lead status.
     */
    public function update(Request $request, $id)
    {
        $table = $this->getTableName();

        $request->validate([
            'status' => 'required|string|max:50',
        ]);

        DB::table($table)->where('id', $id)->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['status' => true, 'message' => 'Status updated successfully.']);
        }

        return back()->with('success', 'Lead status updated successfully.');
    }

    /**
     * Remove the specified lead.
     */
    public function destroy($id)
    {
        $table = $this->getTableName();

        DB::table($table)->where('id', $id)->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead deleted successfully.');
    }
}
