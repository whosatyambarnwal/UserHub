@extends('layouts.user')

@section('title', 'Profile & Settings')

@section('content')
<div class="max-w-2xl mx-auto space-y-6" x-data="{ activeTab: '{{ $errors->hasAny(['current_password', 'password', 'password_confirmation']) ? 'password' : 'profile' }}' }">

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

        @if($errors->hasAny(['name', 'email', 'mobile']))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-xs p-3 rounded">
            <p class="font-semibold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->getMessages() as $key => $messages)
                    @if(in_array($key, ['name', 'email', 'mobile']))
                        @foreach($messages as $msg)
                            <li>{{ $msg }}</li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-4" novalidate>
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-2 bg-white border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('name') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-3 py-2 bg-white border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('email') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="mobile" class="block text-xs font-medium text-gray-700 mb-1">Mobile Phone</label>
                <input id="mobile" type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                    class="w-full px-3 py-2 bg-white border @error('mobile') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('mobile') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                    placeholder="+91 98765 43210">
                @error('mobile')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
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

        @if($errors->hasAny(['current_password', 'password', 'password_confirmation']))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-xs p-3 rounded">
            <p class="font-semibold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->getMessages() as $key => $messages)
                    @if(in_array($key, ['current_password', 'password', 'password_confirmation']))
                        @foreach($messages as $msg)
                            <li>{{ $msg }}</li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('user.password.change') }}" class="space-y-4" novalidate>
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-xs font-medium text-gray-700 mb-1">
                    Current Password <span class="text-red-500">*</span>
                </label>
                <input id="current_password" type="password" name="current_password" required
                    class="w-full px-3 py-2 bg-white border @error('current_password') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('current_password') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                    placeholder="Enter current password">
                @error('current_password')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1">
                        New Password <span class="text-red-500">*</span>
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
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 bg-white border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('password_confirmation') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                        placeholder="Repeat new password">
                    @error('password_confirmation')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
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
