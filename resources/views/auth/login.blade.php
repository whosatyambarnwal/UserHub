@extends('layouts.auth')

@section('title', 'User Login')

@section('content')
<div class="bg-white border border-gray-200 rounded-lg p-8 shadow-sm">
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-gray-900">User Login</h2>
        <p class="text-xs text-gray-500 mt-1">Sign in to your account</p>
    </div>

    <!-- Flash Alerts -->
    @if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-xs p-3 rounded">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-xs p-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-xs p-3 rounded">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email', 'user@yopmail.com') }}" required autofocus
                class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                placeholder="user@yopmail.com">
        </div>

        <div>
            <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required value="password123"
                class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between text-xs">
            <div class="flex items-center">
                <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-gray-600">Remember me</label>
            </div>
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
        </div>

        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm transition">
            Sign In
        </button>
    </form>

    <div class="mt-6 pt-4 border-t border-gray-100 text-center">
        <p class="text-xs text-gray-500">
            Administrator? <a href="{{ route('admin.login') }}" class="text-blue-600 hover:underline">Admin Login</a>
        </p>
    </div>
</div>
@endsection
