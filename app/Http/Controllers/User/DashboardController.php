<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $recentActivities = ActivityLog::where('user_id', $user->id)->latest()->take(5)->get();

        return view('user.dashboard', compact('user', 'recentActivities'));
    }
}
