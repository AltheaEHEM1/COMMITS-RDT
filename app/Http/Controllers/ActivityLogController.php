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

        $logs = Activity::latest()->get()->groupBy(function ($log) {
            return $log->created_at->format('F j, Y');
        });

        $logs = Activity::latest()->paginate(10);
        return view('superadmin.auditlog', compact('logs'));
    }
}
