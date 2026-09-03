@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('header_title', 'System Activity Logs')

@section('content')
<div class="space-y-4">

    <!-- Search Box -->
    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
            <div class="w-full sm:w-80">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-md text-xs text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search logs by action, user, IP...">
            </div>

            <div class="flex items-center space-x-2 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.activity-logs.index') }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-medium border border-gray-300 transition">
                    Reset
                </a>
                <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-medium transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-wider font-medium border-b border-gray-200">
                        <th class="py-3 px-4">Action</th>
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">IP Address</th>
                        <th class="py-3 px-4 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded font-medium bg-blue-50 text-blue-700">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @if($log->user)
                                <a href="{{ route('admin.users.show', $log->user) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                    {{ $log->user->name }}
                                </a>
                                <span class="block text-[11px] text-gray-400">{{ $log->user->email }}</span>
                            @else
                                <span class="text-gray-400">System</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-gray-600">
                            {{ $log->description ?? '—' }}
                        </td>
                        <td class="py-3 px-4 font-mono text-[11px] text-gray-500">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </td>
                        <td class="py-3 px-4 text-right text-gray-500 whitespace-nowrap">
                            <span>{{ $log->created_at->format('M d, Y H:i:s') }}</span>
                            <span class="block text-[10px] text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">No activity logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-3 border-t border-gray-200 bg-gray-50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
