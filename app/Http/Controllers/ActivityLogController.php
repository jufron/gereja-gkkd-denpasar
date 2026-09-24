<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    /**
     * Display the activity log with server-side filters.
     */
    public function index(Request $request)
    {
        $activities = Activity::query()
            ->with(['causer', 'subject'])
            ->when($request->filled('q'), fn ($query) => $query->where('description', 'like', "%{$request->q}%"))
            ->when($request->filled('log_name'), fn ($query) => $query->where('log_name', $request->log_name))
            ->when($request->filled('causer_id'), fn ($query) => $query->where('causer_id', $request->causer_id))
            ->when($request->filled('event'), fn ($query) => $query->where('description', $request->event))
            ->when($request->filled('from'), fn ($query) => $query->whereDate('created_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('created_at', '<=', $request->to))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => Activity::count(),
            'today' => Activity::whereDate('created_at', today())->count(),
            'logins_today' => Activity::where('description', 'login')->whereDate('created_at', today())->count(),
            'failed' => Activity::where('description', 'login_gagal')->count(),
        ];

        $events = Activity::select('description')
            ->distinct()
            ->orderBy('description')
            ->pluck('description');

        return view('dashboard.activity-log', [
            'activities' => $activities,
            'stats' => $stats,
            'events' => $events,
            'filters' => $request->only(['q', 'log_name', 'causer_id', 'event', 'from', 'to']),
        ]);
    }
}
