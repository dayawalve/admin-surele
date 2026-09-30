<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $data = Domain::get();
        return view('admin.domains.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        return view('admin.domains.create');
    }

    public function store(Request $request)
    {
        $domain = new Domain();
        $domain->name = $request->domain;
        $domain->save();

        return redirect()->route('admin.domains.index')->with('success', 'Domain created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $domain = Domain::findOrFail($id);
        return view('admin.domains.edit', compact('domain'));
    }

    public function update(Request $request, string $id)
    {
        $domain = Domain::findOrFail($id);
        $domain->name = $request->domain;
        $domain->save();

        return redirect()->route('admin.domains.index')->with('success', 'Domain updated successfully.');
    }

    public function destroy(string $id)
    {
        $domain = Domain::findOrFail($id);
        $domain->delete();

        return redirect()->route('admin.domains.index')->with('success', 'Domain deleted successfully.');
    }

    public function status($id)
    {
        $domain = Domain::findOrFail($id);
        $domain->status = ($domain->status === 'true') ? 'false' : 'true';
        $domain->save();
        $message = ($domain->status === 'true') ? 'Domain activated successfully.' : 'Domain deactivated successfully.';

        return redirect()->route('admin.domains.index')->with('success', $message);
    }
}
