@extends('layouts.admin')

@section('title', 'Edit User')
@section('header_title', 'Edit User: ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-4">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-600 hover:underline">
            &larr; Back to Users List
        </a>
        <a href="{{ route('admin.users.show', $user) }}" class="text-xs text-gray-600 hover:underline">
            View Details
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">Edit User Details</h3>
            <span class="px-2 py-0.5 rounded text-xs font-medium {{ $user->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                Status: {{ ucfirst($user->status) }}
            </span>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="mobile" class="block text-xs font-medium text-gray-700 mb-1">Mobile Number</label>
                    <input id="mobile" type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="+91 98765 43210">
                </div>

                <div>
                    <label for="role" class="block text-xs font-medium text-gray-700 mb-1">
                        Role <span class="text-red-500">*</span>
                    </label>
                    @if($user->isSuperAdmin())
                        <input type="hidden" name="role" value="admin">
                        <div class="px-3 py-2 bg-gray-100 border border-gray-200 rounded-md text-sm text-gray-600 font-medium">
                            <i class="fa-solid fa-lock text-xs mr-1 text-gray-400"></i> Super Admin
                        </div>
                    @else
                        <select id="role" name="role" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    @endif
                </div>

                <div>
                    <label for="status" class="block text-xs font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    @if($user->isSuperAdmin())
                        <input type="hidden" name="status" value="active">
                        <div class="px-3 py-2 bg-gray-100 border border-gray-200 rounded-md text-sm text-green-700 font-medium">
                            <i class="fa-solid fa-lock text-xs mr-1 text-gray-400"></i> Active (Locked)
                        </div>
                    @else
                        <select id="status" name="status" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    @endif
                </div>
            </div>

            <div class="pt-3 border-t border-gray-200">
                <p class="text-xs font-semibold text-gray-700 mb-2">Change Password (Optional)</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-medium text-gray-600 mb-1">New Password</label>
                        <input id="password" type="password" name="password"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Leave blank to keep current">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-medium text-gray-600 mb-1">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Repeat new password">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 flex justify-end space-x-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-medium border border-gray-300 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-medium transition">
                    Update User
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
