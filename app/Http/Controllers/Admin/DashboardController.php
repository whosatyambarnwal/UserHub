<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with stats and activity feed.
     */
    public function index(): View
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalNormalUsers = User::where('role', 'user')->count();
        $trashCount = User::onlyTrashed()->count();

        $recentUsers = User::latest()->take(5)->get();
        $recentActivities = ActivityLog::with('user')->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'totalAdmins',
            'totalNormalUsers',
            'trashCount',
            'recentUsers',
            'recentActivities'
        ));
    }
}
