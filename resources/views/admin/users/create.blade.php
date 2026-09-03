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

        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-xs p-3 rounded">
            <p class="font-semibold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4" novalidate>
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 bg-white border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('name') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                        placeholder="Rohan Gupta">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 bg-white border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('email') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                        placeholder="rohan.gupta@yopmail.com">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="mobile" class="block text-xs font-medium text-gray-700 mb-1">Mobile Number</label>
                    <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}"
                        class="w-full px-3 py-2 bg-white border @error('mobile') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('mobile') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                        placeholder="+91 98765 43210">
                    @error('mobile')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-xs font-medium text-gray-700 mb-1">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select id="role" name="role" required class="w-full px-3 py-2 bg-white border @error('role') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('role') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-xs font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required class="w-full px-3 py-2 bg-white border @error('status') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('status') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2 bg-white border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('password') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                        placeholder="Min 8 characters">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 bg-white border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('password_confirmation') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                        placeholder="Repeat password">
                    @error('password_confirmation')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
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
