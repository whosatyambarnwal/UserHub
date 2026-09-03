@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome Card -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Welcome, {{ $user->name }}</h1>
            <p class="text-xs text-gray-500 mt-0.5">Manage your personal profile and account settings.</p>
        </div>
        <a href="{{ route('user.profile') }}" class="inline-flex items-center px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-medium transition self-start sm:self-auto">
            Edit Profile
        </a>
    </div>

    <!-- 3 Simple Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase">Account Status</p>
            <p class="text-lg font-bold text-green-600 mt-1 capitalize">{{ $user->status }}</p>
            <p class="text-[11px] text-gray-400 mt-1">Full account access</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase">Role</p>
            <p class="text-lg font-bold text-gray-900 mt-1 capitalize">{{ $user->role }}</p>
            <p class="text-[11px] text-gray-400 mt-1">Standard user permissions</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-xs font-medium text-gray-500 uppercase">Joined</p>
            <p class="text-lg font-bold text-gray-900 mt-1">{{ $user->created_at->format('M Y') }}</p>
            <p class="text-[11px] text-gray-400 mt-1">{{ $user->created_at->format('F d, Y') }}</p>
        </div>
    </div>

    <!-- Details & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Profile Summary -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900">Profile Information</h3>
                <a href="{{ route('user.profile') }}" class="text-xs text-blue-600 hover:underline">Update</a>
            </div>

            <dl class="space-y-3 text-xs">
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">Name</dt>
                    <dd class="font-medium text-gray-900">{{ $user->name }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-medium text-gray-900">{{ $user->email }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <dt class="text-gray-500">Mobile</dt>
                    <dd class="font-medium text-gray-900">{{ $user->mobile ?? 'Not provided' }}</dd>
                </div>
                <div class="flex justify-between py-1">
                    <dt class="text-gray-500">Password</dt>
                    <dd class="text-gray-900">••••••••</dd>
                </div>
            </dl>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="pb-3 mb-4 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900">Recent Activity</h3>
            </div>

            <div class="space-y-3">
                @forelse($recentActivities as $activity)
                <div class="text-xs pb-2 border-b border-gray-100 last:border-0">
                    <div class="flex justify-between items-center text-gray-900 font-medium">
                        <span>{{ $activity->action }}</span>
                        <span class="text-[10px] text-gray-400 font-normal">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-500 mt-0.5">{{ $activity->description }}</p>
                </div>
                @empty
                <p class="text-xs text-gray-500 text-center py-4">No recent account activity.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
