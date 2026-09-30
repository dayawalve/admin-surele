<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePermission
{
    public function handle(Request $request, Closure $next)
    {      
        if (Auth::check()) {
            $User = Auth::user();
            if (Auth::user()->can($request->route()->getName())) {
                return $next($request);
            } else {
                return redirect()->route('admin.index')->with('error','You do not have the necessary permissions to perform this action.');
            }
        }
        return $next($request);
    }
}
