@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-8 shadow-sm">
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-gray-900">Create Account</h2>
        <p class="text-xs text-gray-500 mt-1">Register for a new user account</p>
    </div>

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

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
        @csrf

        <div>
            <label for="name" class="block text-xs font-medium text-gray-700 mb-1">
                Full Name <span class="text-red-500">*</span>
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-3 py-2 bg-white border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 @error('name') focus:ring-red-500 focus:border-red-500 @else focus:ring-blue-500 focus:border-blue-500 @enderror"
                placeholder="Aarav Sharma">
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
                placeholder="aarav.sharma@yopmail.com">
            @error('email')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

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

        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm transition">
            Register Account
        </button>
    </form>

    <div class="mt-6 pt-4 border-t border-gray-100 text-center">
        <p class="text-xs text-gray-500">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign In</a>
        </p>
    </div>
</div>
@endsection
