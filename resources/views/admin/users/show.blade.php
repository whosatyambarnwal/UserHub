@extends('layouts.admin')

@section('title', 'User Profile')
@section('header_title', 'User: ' . $user->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-4">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-600 hover:underline">
            &larr; Back to Users List
        </a>
        <div class="space-x-2">
            @if($user->id !== auth()->id() && $user->isActive())
            <a href="{{ route('admin.users.impersonate', $user) }}" class="text-xs text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 px-2.5 py-1 rounded transition">
                Impersonate
            </a>
            @endif
            <a href="{{ route('admin.users.edit', $user) }}" class="text-xs text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-2.5 py-1 rounded transition">
                Edit User
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                <p class="text-xs text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="space-x-1">
                @if($user->isAdmin())
                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">Admin</span>
                @else
                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">User</span>
                @endif

                @if($user->isActive())
                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Active</span>
                @else
                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                @endif
            </div>
        </div>

        <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 text-xs">
            <div>
                <dt class="text-gray-500 uppercase font-medium">Mobile Phone</dt>
                <dd class="text-gray-900 font-medium mt-1">{{ $user->mobile ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 uppercase font-medium">Joined Date</dt>
                <dd class="text-gray-900 font-medium mt-1">{{ $user->created_at->format('M d, Y') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 uppercase font-medium">Last Updated</dt>
                <dd class="text-gray-900 font-medium mt-1">{{ $user->updated_at->format('M d, Y H:i') }}</dd>
            </div>
        </dl>
    </div>

    <!-- Activity History -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <h4 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-100">User Activity History</h4>
        <div class="space-y-3">
            @forelse($userLogs as $log)
            <div class="text-xs pb-2 border-b border-gray-100 last:border-0">
                <div class="flex justify-between items-center text-gray-900 font-medium">
                    <span>{{ $log->action }}</span>
                    <span class="text-[10px] text-gray-400 font-normal">{{ $log->created_at->format('M d, Y H:i:s') }}</span>
                </div>
                <p class="text-gray-500 mt-0.5">{{ $log->description }}</p>
                <span class="text-[10px] text-gray-400">IP: {{ $log->ip_address ?? '127.0.0.1' }}</span>
            </div>
            @empty
            <p class="text-xs text-gray-500 text-center py-4">No activity logged for this user.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
