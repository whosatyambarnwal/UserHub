@extends('layouts.admin')

@section('title', 'Create User')
@section('header_title', 'Create New User')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">

    <div>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-600 hover:underline">
            &larr; Back to Users List
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <h3 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">User Details</h3>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Rohan Gupta">
                </div>

                <div>
                    <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="rohan.gupta@yopmail.com">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="mobile" class="block text-xs font-medium text-gray-700 mb-1">Mobile Number</label>
                    <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="+91 98765 43210">
                </div>

                <div>
                    <label for="role" class="block text-xs font-medium text-gray-700 mb-1">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select id="role" name="role" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Min 8 characters">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Repeat password">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 flex justify-end space-x-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-medium border border-gray-300 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-medium transition">
                    Create User
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
