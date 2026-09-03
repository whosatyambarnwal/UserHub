@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header_title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">

    <!-- 4 Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Users -->
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Users</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalUsers) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span>{{ $totalNormalUsers }} Regular Users</span>
            </div>
        </div>

        <!-- Active Users -->
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Active Users</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1">{{ number_format($activeUsers) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span>{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0 }}% of total users</span>
            </div>
        </div>

        <!-- Inactive Users -->
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Inactive Users</p>
                    <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($inactiveUsers) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-user-xmark"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span>Deactivated accounts</span>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Admins</p>
                    <h3 class="text-2xl font-bold text-purple-600 mt-1">{{ number_format($totalAdmins) }}</h3>
                </div>
                <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i class="fa-solid fa-shield"></i>
                </div>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span>Administrators</span>
            </div>
        </div>
    </div>

    <!-- Recent Users & Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Users Table -->
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-600 hover:underline">View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                            <th class="py-3 px-4">User</th>
                            <th class="py-3 px-4">Role</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @forelse($recentUsers as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                <span class="block text-gray-500">{{ $user->email }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($user->isAdmin())
                                    <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 font-medium">Admin</span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-800 font-medium">User</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->isActive())
                                    <span class="px-2 py-0.5 rounded bg-green-100 text-green-800 font-medium">Active</span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-red-100 text-red-800 font-medium">Inactive</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <a href="{{ route('admin.users.show', $user) }}" class="text-gray-600 hover:underline">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 text-center text-gray-500">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Recent Activity</h3>
                <a href="{{ route('admin.activity-logs.index') }}" class="text-xs text-blue-600 hover:underline">View All</a>
            </div>

            <div class="p-5 space-y-3">
                @forelse($recentActivities as $log)
                <div class="text-xs pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="flex justify-between items-center text-gray-900 font-medium">
                        <span>{{ $log->action }}</span>
                        <span class="text-[10px] text-gray-400 font-normal">{{ $log->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-500 mt-0.5">{{ $log->description }}</p>
                    @if($log->user)
                    <span class="text-[10px] text-gray-400">By: {{ $log->user->name }}</span>
                    @endif
                </div>
                @empty
                <p class="text-xs text-gray-500 text-center py-4">No recent activity logs.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
