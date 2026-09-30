<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $employee = Employee::where('email', $request->email)->first();

        if (!$employee) {
            return response()->json([
                'status'  => false,
                'message' => 'Employee not found'
            ], 404);
        }

        if ($employee->status !== 'active') {
            return response()->json([
                'status'  => false,
                'message' => 'Employee account is inactive'
            ], 403);
        }

        if (!Hash::check($request->password, $employee->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $employee->tokens()->delete();

        $token = $employee->createToken('employee-token')->plainTextToken;

        $employee->is_logged_in = 1;
        $employee->save();
    
        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'employee_id' => $employee->id,
            'email' => $employee->email,
            'name'  => $employee->name,
        ]);
    }

    public function logout(Request $request)
    {
        $employee = $request->user();

        if ($employee) {
            $employee->tokens()->delete();
            $employee->is_logged_in = 0;
            $employee->save();
        }


        $employee->tokens()->delete();

        $employee->is_logged_in = 0;
        $employee->save();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }

}

