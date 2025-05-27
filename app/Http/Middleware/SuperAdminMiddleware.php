<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and has superadmin role
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            // Redirect to dashboard with error message if not superadmin
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this area.');
        }
        
        return $next($request);
    }
}