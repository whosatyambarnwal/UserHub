@extends('layouts.admin')

@section('title', $isTrashView ? 'Trash / Deleted Users' : 'Users')
@section('header_title', $isTrashView ? 'Deleted Users' : 'User Management')

@section('content')
<div class="space-y-4">

    <!-- Top Action Bar & Tabs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <!-- Tabs -->
        <div class="flex items-center space-x-1 border-b border-gray-200">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-xs font-medium border-b-2 transition {{ !$isTrashView ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Active Users ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.users.index', ['view' => 'trash']) }}" class="px-4 py-2 text-xs font-medium border-b-2 transition {{ $isTrashView ? 'border-amber-600 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Trash ({{ $trashCount }})
            </a>
        </div>

        <!-- Add Button -->
        @if(!$isTrashView)
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-medium transition shadow-sm self-start sm:self-auto">
            <i class="fa-solid fa-plus mr-1.5"></i> Add User
        </a>
        @endif
    </div>

    <!-- Filters Box -->
    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            @if($isTrashView)
            <input type="hidden" name="view" value="trash">
            @endif

            <div class="sm:col-span-2">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                <input id="search" type="text" name="search" value="{{ request('search') }}"
                    class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-md text-xs text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search by name, email, or mobile...">
            </div>

            <div>
                <label for="role" class="block text-xs font-medium text-gray-700 mb-1">Role</label>
                <select id="role" name="role" class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-md text-xs text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="w-full px-3 py-1.5 bg-white border border-gray-300 rounded-md text-xs text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="sm:col-span-4 flex justify-end space-x-2 pt-1">
                <a href="{{ route('admin.users.index', $isTrashView ? ['view' => 'trash'] : []) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-medium border border-gray-300 transition">
                    Reset
                </a>
                <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-medium transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-700">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-wider font-medium border-b border-gray-200">
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-4">Mobile</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">{{ $isTrashView ? 'Deleted At' : 'Joined Date' }}</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <!-- User -->
                        <td class="py-3 px-4">
                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                            @if($user->id === auth()->id())
                            <span class="ml-1 text-[10px] bg-blue-100 text-blue-700 px-1 py-0.5 rounded">You</span>
                            @endif
                            <span class="block text-gray-500 text-[11px]">{{ $user->email }}</span>
                        </td>

                        <!-- Mobile -->
                        <td class="py-3 px-4 text-gray-600">
                            {{ $user->mobile ?? '—' }}
                        </td>

                        <!-- Role -->
                        <td class="py-3 px-4">
                            @if($user->isSuperAdmin())
                                <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 font-semibold">
                                    <i class="fa-solid fa-crown text-[10px] mr-0.5"></i> Super Admin
                                </span>
                            @elseif($user->isAdmin())
                                <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 font-medium">Admin</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-800 font-medium">User</span>
                            @endif
                        </td>

                        <!-- Status & Toggle -->
                        <td class="py-3 px-4">
                            @if(!$isTrashView)
                                @if($user->isSuperAdmin())
                                    <span class="px-2 py-0.5 rounded font-medium text-xs bg-green-100 text-green-800" title="Super Admin is always active">
                                        Active
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" @if($user->id === auth()->id()) disabled title="Cannot toggle your own account" @endif
                                            class="px-2 py-0.5 rounded font-medium text-xs transition {{ $user->isActive() ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                            {{ ucfirst($user->status) }}
                                        </button>
                                    </form>
                                @endif
                            @else
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-medium">
                                    {{ ucfirst($user->status) }}
                                </span>
                            @endif
                        </td>

                        <!-- Date -->
                        <td class="py-3 px-4 text-gray-500">
                            {{ $isTrashView ? $user->deleted_at->format('M d, Y') : $user->created_at->format('M d, Y') }}
                        </td>

                        <!-- Actions -->
                        <td class="py-3 px-4 text-right space-x-2">
                            @if(!$isTrashView)
                                @if($user->isSuperAdmin() && $user->id !== auth()->id())
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-gray-600 hover:underline">View</a>
                                    <span class="text-xs text-amber-700 font-medium bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded" title="Super Admin cannot be modified, deleted or impersonated">Protected</span>
                                @else
                                    @if($user->id !== auth()->id() && $user->isActive() && !$user->isSuperAdmin())
                                    <a href="{{ route('admin.users.impersonate', $user) }}" class="text-amber-600 hover:underline" title="Login as user">Impersonate</a>
                                    @endif
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-gray-600 hover:underline">View</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>
                                    @if($user->id !== auth()->id() && !$user->isSuperAdmin())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Move {{ $user->name }} to trash?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                    @endif
                                @endif
                            @else
                                <form method="POST" action="{{ route('admin.users.restore', $user->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline mr-2">Restore</button>
                                </form>
                                @if(!$user->isSuperAdmin())
                                <form method="POST" action="{{ route('admin.users.force-delete', $user->id) }}" onsubmit="return confirm('Permanently delete {{ $user->name }}?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Permanent Delete</button>
                                </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-3 border-t border-gray-200 bg-gray-50">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
