<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use App\Models\Screenshot;
use App\Models\Domain;
use App\Models\TrackingData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeDailyActivity;
use App\Models\IdealTimeReason;
use App\Models\BasicSetting;
use App\Models\Employee;
use Carbon\Carbon;


class CommonController extends Controller
{
    public function storeScreenshots(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }
        
        $savedScreenshots = [];
        $basePath = public_path('storage/screenshots/' . $user->id);
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }
        foreach ($request->screenshots as $imageBase64) {
            $imageData = base64_decode($imageBase64);
            if ($imageData === false) {
                continue;
            }
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_buffer($finfo, $imageData);
            finfo_close($finfo);
            $extension = match ($mime) {
                'image/png'  => 'png',
                'image/jpeg' => 'jpg',
                default      => 'png'
            };
            $fileName = now()->format('YmdHisv') . '.' . $extension;
            file_put_contents($basePath . '/' . $fileName, $imageData);
            $savedScreenshots[] = Screenshot::create([
                'employee_id'     => $user->id,
                'screenshot_path' => 'public/storage/screenshots/' . $user->id . '/' . $fileName,
                'date_time'       => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Screenshots stored successfully',
            'data'    => $savedScreenshots
        ], 201);
    }

    public function getDomains(Request $request)
    {
        try {
            $employee = Auth::user();

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
                ->get()
                ->map(function ($domain) {
                    return [
                        'id'         => $domain->id,
                        'name'       => $domain->name,
                        'is_enabled' => $domain->is_enabled == 1 ? true : false,
                    ];
                });

            return response()->json([
                'success' => true,
                'count'   => $domains->count(),
                'data'    => $domains,
            ], 200);

        } catch (\Throwable $e) {
            \Log::error('Get Domains Error', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch domains',
            ], 500);
        }
    }
    
    public function getAllDomains(Request $request)
    {
        try {
            $domains = Domain::get();

            return response()->json([
                'success' => true,
                'data'    => $domains,
            ], 200);

        } catch (\Throwable $e) {
            \Log::error('Get Domains Error', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch domains',
            ], 500);
        }
    }

    public function storeTrackingData(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        try {
            $validated = $request->validate([
                'date_time'          => 'required|date',
                'active_tabs'        => 'required|string',
                'active_tabs_time'   => 'required|integer|min:0',
            ]);

            $trackingData = TrackingData::create([
                'employee_id'        => $user->id,
                'date_time'          => $validated['date_time'],
                'active_tabs'        => $validated['active_tabs'],
                'active_tabs_time'   => $validated['active_tabs_time'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tracking data stored successfully',
                'data'    => $trackingData,
            ], 201);

        } catch (ValidationException $e) {
            Log::warning('Tracking validation failed', [
                'errors' => $e->errors(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {
            Log::error('Tracking data store failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to store tracking data',
            ], 500);
        }
    }

    //NEW 24-02-2026
    // public function EmployeeDailyActivity(Request $request)
    // {
    //     $employee = Auth::user();

    //     if (!$employee) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => 'Unauthorized'
    //         ], 401);
    //     }

    //     $validator = Validator::make($request->all(), [
    //         'activity_date'  => 'required|date',
    //         'total_seconds'  => 'required|integer|min:0',
    //         'active_seconds' => 'required|integer|min:0',
    //         'idle_seconds'   => 'required|integer|min:0',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $activity = EmployeeDailyActivity::firstOrNew([
    //         'employee_id'   => $employee->id,
    //         'activity_date' => $request->activity_date,
    //     ]);

    //     if ($activity->exists) {
            
    //         if ($request->total_seconds >= $activity->total_seconds) {

    //             $activity->total_seconds  = $request->total_seconds;
    //             $activity->active_seconds = $request->active_seconds;
    //             $activity->idle_seconds   = $request->idle_seconds;

    //         } else {

    //             $activity->total_seconds  += $request->total_seconds;
    //             $activity->active_seconds += $request->active_seconds;
    //             $activity->idle_seconds   += $request->idle_seconds;
    //         }

    //     } else {

    //         $activity->total_seconds  = $request->total_seconds;
    //         $activity->active_seconds = $request->active_seconds;
    //         $activity->idle_seconds   = $request->idle_seconds;
    //     }

    //     $activity->save();

    //     return response()->json([
    //         'status'  => true,
    //         'message' => 'Daily activity updated successfully',
    //         'data'    => $activity
    //     ], 200);
    // }

    public function EmployeeDailyActivity(Request $request)
    {
        $employee = Auth::user();

        if (!$employee) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'activity_date'  => 'required|date',
            'total_seconds'  => 'required|integer|min:0',
            'active_seconds' => 'required|integer|min:0',
            'idle_seconds'   => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $activity = EmployeeDailyActivity::firstOrNew([
            'employee_id'   => $employee->id,
            'activity_date' => $request->activity_date,
        ]);
        
        if ($activity->exists) {

            $activity->total_seconds  += $request->total_seconds;
            $activity->active_seconds += $request->active_seconds;
            $activity->idle_seconds   += $request->idle_seconds;

        } else {

            $activity->total_seconds  = $request->total_seconds;
            $activity->active_seconds = $request->active_seconds;
            $activity->idle_seconds   = $request->idle_seconds;
        }

        $activity->save();

        return response()->json([
            'status'  => true,
            'message' => 'Daily activity updated successfully',
            'data'    => $activity
        ], 200);
    }

    public function submitIdealTimeReason(Request $request)
    {
        $employee = Auth::user();

        $startTime = Carbon::parse($request->ideal_start_time);
        $endTime   = Carbon::parse($request->ideal_end_time);

        $totalSeconds = $startTime->diffInSeconds($endTime);

        $basicSetting = BasicSetting::first();

        $finalSeconds = $totalSeconds;

        if ($basicSetting) {
            $finalSeconds += $basicSetting->idle_threshold;
        }

        $idealTimeReason = IdealTimeReason::create([
            'employee_id'      => $employee->id,
            'ideal_start_time' => $startTime,
            'ideal_end_time'   => $endTime,
            'total_seconds'    => $finalSeconds,
            'reason'           => $request->reason,
            'status'           => 'pending',
        ]);

        $today = Carbon::today();

        $dailyActivity = EmployeeDailyActivity::where('employee_id', $employee->id)
            ->whereDate('activity_date', $today)
            ->first();

        if ($dailyActivity && $basicSetting) {
            $dailyActivity->total_seconds += $basicSetting->idle_threshold;
            $dailyActivity->idle_seconds += $basicSetting->idle_threshold;
            $dailyActivity->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Ideal time reason submitted successfully',
            'data'    => $idealTimeReason
        ], 201);
    }

    public function getBasicSettings()
    {
        $setting = BasicSetting::first();

        if (!$setting) {
            return response()->json([
                'status'  => false,
                'message' => 'Basic settings not found'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Basic settings fetched successfully',
            'data'    => $setting
         ], 200);
    }


    public function EmployeeWorkTime(Request $request)
    {
        try {
            $employee = Auth::user();
            $today = Carbon::today()->format('Y-m-d');

            $data = EmployeeDailyActivity::where('employee_id', $employee->id)
                        ->where('activity_date', $today)
                        ->first();

            if (!$data) {
                return response()->json([
                    'success' => true,
                    'total_time'  => "00:00:00",
                    'active_time' => "00:00:00",
                    'idle_time'   => "00:00:00",
                ], 200);
            }

            $totalTime  = gmdate("H:i:s", $data->total_seconds);
            $activeTime = gmdate("H:i:s", $data->active_seconds);
            $idleTime   = gmdate("H:i:s", $data->idle_seconds);

            return response()->json([
                'success'     => true,
                'total_time'  => $totalTime,
                'active_time' => $activeTime,
                'idle_time'   => $idleTime,
            ], 200);

        } catch (\Throwable $e) {

            \Log::error('Employee Work Time Error', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch today work time',
            ], 500);
        }
    }


    public function autoLogoutAll()
    {
        Employee::query()->update([
            'is_logged_in' => 0
        ]);

        return response()->json([
            'status' => true,
            'message' => 'All employees logged out successfully'
        ]);
    }

}
