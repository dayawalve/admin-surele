<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\College;
use App\Models\TrainingProgram;
use App\Models\CompanySetting;

class CompanySettingsController extends Controller
{

    public function index()
    {
        $data = CompanySetting::all(); 
        return view('admin.company-settings.index', compact('data'));
    }


    public function create()
    {
         return view('admin.company-settings.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'company_name'   => 'required|string|max:255',
            'company_email'  => 'nullable|email',
            'company_phone'  => 'nullable|string|max:20',
            'company_website'=> 'nullable|url',
            'logo'           => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'favicon'        => 'nullable|image|mimes:png,jpg,jpeg,ico|max:1024',
        ]);

        if (CompanySetting::exists()) {
            return redirect()->back()->with('error', 'Company settings already exist.');
        }

        $company = new CompanySetting();
        $company->company_name    = $request->company_name;
        $company->company_email   = $request->company_email;
        $company->company_phone   = $request->company_phone;
        $company->company_website = $request->company_website;
        $company->address         = $request->address;
        $company->city            = $request->city;
        $company->state           = $request->state;
        $company->country         = $request->country;
        $company->pincode         = $request->pincode;
        $company->gst_number      = $request->gst_number;
        $company->pan_number      = $request->pan_number;
        $company->facebook_url    = $request->facebook_url;
        $company->instagram_url   = $request->instagram_url;
        $company->linkedin_url    = $request->linkedin_url;
        $company->twitter_url     = $request->twitter_url;
        $company->is_active       = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $logoName = time().'_logo.'.$request->logo->extension();
            $request->logo->move(public_path('storage/company'), $logoName);
            $company->logo = 'public/storage/company/'.$logoName;
        }

        if ($request->hasFile('favicon')) {
            $faviconName = time().'_favicon.'.$request->favicon->extension();
            $request->favicon->move(public_path('storage/company'), $faviconName);
            $company->favicon = 'public/storage/company/'.$faviconName;
        }

        if ($request->hasFile('digital_signature')) {
            $signatureName = time().'_signature.'.$request->digital_signature->extension();
            $request->digital_signature->move(public_path('storage/company'), $signatureName);
            $company->digital_signature = 'public/storage/company/'.$signatureName;
        }

        $company->save();

        return redirect()->route('admin.company-settings.index')->with('success', 'Company settings saved successfully.');
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $data = CompanySetting::findOrFail($id); 
        return view('admin.company-settings.edit', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email',
            'company_phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,ico|max:1024',
        ]);

        $company = CompanySetting::findOrFail($id);
        $company->company_name    = $request->company_name;
        $company->company_email   = $request->company_email;
        $company->company_phone   = $request->company_phone;
        $company->company_website = $request->company_website;
        $company->address         = $request->address;
        $company->city            = $request->city;
        $company->state           = $request->state;
        $company->country         = $request->country;
        $company->pincode         = $request->pincode;
        $company->gst_number      = $request->gst_number;
        $company->pan_number      = $request->pan_number;
        $company->facebook_url    = $request->facebook_url;
        $company->instagram_url   = $request->instagram_url;
        $company->linkedin_url    = $request->linkedin_url;
        $company->twitter_url     = $request->twitter_url;
        $company->is_active       = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $logoName = time().'_logo.'.$request->logo->extension();
            $request->logo->move(public_path('storage/company'), $logoName);
            $company->logo = 'public/storage/company/'.$logoName;
        }

        if ($request->hasFile('favicon')) {
            $faviconName = time().'_favicon.'.$request->favicon->extension();
            $request->favicon->move(public_path('storage/company'), $faviconName);
            $company->favicon = 'public/storage/company/'.$faviconName;
        }

        if ($request->hasFile('digital_signature')) {
            $signatureName = time().'_signature.'.$request->digital_signature->extension();
            $request->digital_signature->move(public_path('storage/company'), $signatureName);
            $company->digital_signature = 'public/storage/company/'.$signatureName;
        }

        $company->save();

        return redirect()->route('admin.company-settings.index')->with('success', 'Company settings updated successfully.');

    }


    public function destroy(string $id)
    {
        //
    }

}
