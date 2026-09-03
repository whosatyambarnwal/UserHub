<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-100 text-gray-800 flex flex-col font-sans" x-data="{ sidebarOpen: false }">

    <!-- Impersonation Notice -->
    @if(session()->has('impersonated_by'))
    <div class="bg-amber-500 text-white px-4 py-2 text-sm font-medium flex items-center justify-between shadow-sm">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-user-shield"></i>
            <span>You are currently impersonating <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }}).</span>
        </div>
        <a href="{{ route('admin.impersonate.leave') }}" class="inline-flex items-center px-2.5 py-1 bg-white text-amber-900 rounded text-xs font-semibold hover:bg-amber-50 transition">
            Exit Impersonation
        </a>
    </div>
    @endif

    <div class="flex-1 flex overflow-hidden">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-gray-600/50 z-40 lg:hidden" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 border-r border-slate-800 transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-0 flex flex-col justify-between">
            <div>
                <!-- Brand -->
                <div class="flex items-center justify-between h-16 px-6 bg-slate-950 border-b border-slate-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 text-white font-bold text-lg tracking-tight">
                        <span class="text-blue-500"><i class="fa-solid fa-layer-group"></i></span>
                        <span>Admin Panel</span>
                    </a>
                    <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white lg:hidden">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Nav Menu -->
                <nav class="p-4 space-y-1">
                    <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Management</p>

                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-gauge w-5 mr-2 text-sm"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-users w-5 mr-2 text-sm"></i>
                        Users
                    </a>

                    <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-5 mb-2">System</p>

                    <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-list-check w-5 mr-2 text-sm"></i>
                        Activity Logs
                    </a>

                    <a href="{{ route('user.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-slate-400 hover:bg-slate-800 hover:text-slate-200 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square w-5 mr-2 text-sm"></i>
                        User View
                    </a>
                </nav>
            </div>

            <!-- Profile / Logout Footer -->
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <div class="flex items-center justify-between">
                    <div class="truncate">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" title="Logout" class="p-1.5 text-slate-400 hover:text-red-400 rounded transition">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-gray-200 px-6 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-900 lg:hidden">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">
                        @yield('header_title', 'Dashboard')
                    </h1>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="text-xs font-medium px-2.5 py-1 bg-gray-100 text-gray-700 rounded border border-gray-200">
                        Role: Admin
                    </span>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-gray-600 hover:text-red-600 font-medium px-2 py-1 rounded hover:bg-gray-50 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <!-- Flash Alerts -->
                @if(session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md text-sm flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-check text-green-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-5 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md text-sm flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-xmark text-red-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                @endif

                @if(session('info'))
                <div class="mb-5 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-md text-sm flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-circle-info text-blue-600"></i>
                        <span>{{ session('info') }}</span>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-800 p-4 rounded-md text-sm">
                    <p class="font-semibold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-xs text-red-700">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
