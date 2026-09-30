<?php

namespace App\Http\Controllers;

use App\Models\BasicSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BasicSettingController extends Controller
{
    public function index()
    {
        $setting = BasicSetting::first();

        return view('admin.basic_settings.edit', compact('setting'));
    }

    public function store(Request $request)
    {
        if (BasicSetting::exists()) {
            return back()->withErrors(['error' => 'Basic settings already exist. Please update the existing settings.']);
        }

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $setting = BasicSetting::create($request->all());

        return redirect()->route('admin.basic-settings.index')->with('success', 'Basic settings created successfully.');
    }

    public function update(Request $request)
    {
        $setting = BasicSetting::first();

        if (!$setting) {
            return back()->withErrors(['error' => 'Basic settings not found. Please create the settings first.']);
        }

        $validator = $this->validator($request, false);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $setting->update($request->all());

        return redirect()->route('admin.basic-settings.index')->with('success', 'Basic settings updated successfully.');
    }

    public function destroy()
    {
        $setting = BasicSetting::first();

        if (!$setting) {
            return redirect()->back()->withErrors(['error' => 'Basic settings not found.']);
        }

        $setting->delete();

        return redirect()->route('admin.basic-settings.index')->with('success', 'Basic settings deleted successfully.');
    }


    private function validator(Request $request, $required = true)
    {
        return Validator::make($request->all(), [
            'inactivity_threshold'      => ($required ? 'required|' : '') . 'integer|min:1',
            'popup_timeout'             => ($required ? 'required|' : '') . 'integer|min:1',
            'check_interval'            => ($required ? 'required|' : '') . 'integer|min:1',
            'idle_threshold'            => ($required ? 'required|' : '') . 'integer|min:1',
            'send_interval'             => ($required ? 'required|' : '') . 'integer|min:1',

            'screenshot_enabled'        => 'boolean',
            'screenshot_count'          => 'integer|min:0',
            'screenshot_time_period'    => 'integer|min:1',

            'activity_tracker_enabled'  => 'boolean',
            'activity_check_interval'   => 'integer|min:1',

            'blocker_enabled'           => 'boolean',
            'blocker_check_interval'    => 'integer|min:1',
        ]);
    }
}
