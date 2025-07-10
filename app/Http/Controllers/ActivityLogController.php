<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Only allow SuperAdmin to access
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Unauthorized');
        }

        $logs = Activity::with('causer')
            ->latest()
            ->paginate(10);

        // Get login statistics for each user
        $userLoginStats = [];
        $users = \App\Models\User::all();
        
        foreach ($users as $user) {
            $userLoginStats[$user->id] = [
                'successful_logins' => $user->login_count,
                'failed_logins' => $user->failed_login_count,
                'total_attempts' => $user->login_count + $user->failed_login_count
            ];
        }

        return view('superadmin.auditlog', compact('logs', 'userLoginStats'));
    }
}
