<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'User Portal') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-full bg-gray-100 text-gray-800 flex flex-col font-sans" x-data="{ mobileMenuOpen: false }">

    <!-- Impersonation Notice -->
    @if(session()->has('impersonated_by'))
    <div class="bg-amber-500 text-white px-4 py-2 text-sm font-medium flex items-center justify-between shadow-sm">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-user-shield"></i>
            <span>Administrator is viewing portal as <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }}).</span>
        </div>
        <a href="{{ route('admin.impersonate.leave') }}" class="inline-flex items-center px-2.5 py-1 bg-white text-amber-900 rounded text-xs font-semibold hover:bg-amber-50 transition">
            Exit Impersonation
        </a>
    </div>
    @endif

    <!-- Navbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Brand & Nav Links -->
                <div class="flex items-center">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-2 text-gray-900 font-bold text-lg">
                        <span class="text-blue-600"><i class="fa-solid fa-user"></i></span>
                        <span>User Portal</span>
                    </a>
                    <nav class="hidden sm:ml-8 sm:flex sm:space-x-4">
                        <a href="{{ route('user.dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-md transition {{ request()->routeIs('user.dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('user.profile') }}" class="px-3 py-2 text-sm font-medium rounded-md transition {{ request()->routeIs('user.profile') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            Profile & Password
                        </a>
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm font-medium text-purple-700 bg-purple-50 rounded-md hover:bg-purple-100 transition">
                            Admin Panel
                        </a>
                        @endif
                    </nav>
                </div>

                <!-- Right Profile & Logout -->
                <div class="hidden sm:flex sm:items-center sm:space-x-4">
                    <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-gray-600 hover:text-red-600 border border-gray-300 rounded px-2.5 py-1.5 hover:bg-gray-50 transition">
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 p-2">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile dropdown -->
        <div x-show="mobileMenuOpen" class="sm:hidden border-t border-gray-200 px-4 pt-2 pb-3 space-y-1 bg-white" style="display: none;">
            <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">Dashboard</a>
            <a href="{{ route('user.profile') }}" class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.profile') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-gray-100">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 text-sm font-medium text-red-600">Logout</button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Alerts -->
        @if(session('success'))
        <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md text-sm">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 p-4 rounded-md text-sm">
            <ul class="list-disc list-inside space-y-0.5 text-xs text-red-700">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
    </footer>

</body>
</html>
