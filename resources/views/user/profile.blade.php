@extends('layouts.user')

@section('title', 'Profile & Settings')

@section('content')
<div class="max-w-2xl mx-auto space-y-6" x-data="{ activeTab: 'profile' }">

    <!-- Header & Tabs -->
    <div class="flex items-center justify-between border-b border-gray-200 pb-3">
        <h1 class="text-xl font-bold text-gray-900">Account Settings</h1>

        <div class="flex space-x-2">
            <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'" class="px-3 py-1.5 rounded-md text-xs font-medium transition">
                Profile Details
            </button>
            <button @click="activeTab = 'password'" :class="activeTab === 'password' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'" class="px-3 py-1.5 rounded-md text-xs font-medium transition">
                Change Password
            </button>
        </div>
    </div>

    <!-- Tab 1: Profile Info -->
    <div x-show="activeTab === 'profile'" class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Update Profile</h3>

        <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

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

            <div>
                <label for="mobile" class="block text-xs font-medium text-gray-700 mb-1">Mobile Phone</label>
                <input id="mobile" type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="+91 98765 43210">
            </div>

            <div class="pt-4 border-t border-gray-200 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-xs transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Tab 2: Change Password -->
    <div x-show="activeTab === 'password'" class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm" style="display: none;">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">Update Password</h3>

        <form method="POST" action="{{ route('user.password.change') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-xs font-medium text-gray-700 mb-1">
                    Current Password <span class="text-red-500">*</span>
                </label>
                <input id="current_password" type="password" name="current_password" required
                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter current password">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Min 8 characters">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Repeat new password">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-xs transition">
                    Update Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
