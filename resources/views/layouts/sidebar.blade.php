<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GiziTrack')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css/figtree.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-emerald-900 flex flex-col flex-shrink-0 transition-all duration-300 shadow-2xl relative z-20">
            <!-- Branding -->
            <div class="h-20 flex items-center px-6 border-b border-emerald-800/50">
                <div class="flex items-center gap-3">
                    <span class="text-3xl filter drop-shadow-md">🥗</span>
                    <span class="text-xl font-black text-white tracking-tight uppercase">GiziTrack</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
                @php
                    $role = auth()->user()->role->value;
                    $currentRoute = request()->route()->getName();

                    $activeClass = "bg-emerald-800 text-white shadow-lg shadow-black/10";
                    $inactiveClass = "text-emerald-100/70 hover:bg-emerald-800/50 hover:text-white";
                    $baseClass = "flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 group";
                @endphp

                @if($role === 'super_admin')
                    <a href="{{ route('admin.dashboard') }}" class="{{ $baseClass }} {{ $currentRoute === 'admin.dashboard' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Overview
                    </a>
                    <a href="{{ route('admin.distributions.index') }}" class="{{ $baseClass }} {{ str_starts_with($currentRoute, 'admin.distributions') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        Distributions
                    </a>
                    <a href="{{ route('super_admin.users.index') }}" class="{{ $baseClass }} {{ str_starts_with($currentRoute, 'super_admin.users') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Manage Accounts
                    </a>
                @elseif($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="{{ $baseClass }} {{ $currentRoute === 'admin.dashboard' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Overview
                    </a>
                    <a href="{{ route('admin.distributions.index') }}" class="{{ $baseClass }} {{ str_starts_with($currentRoute, 'admin.distributions') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        Distributions
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="{{ $baseClass }} {{ str_starts_with($currentRoute, 'admin.users') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Manage Accounts
                    </a>
                @elseif($role === 'vendor')
                    <a href="{{ route('vendor.dashboard') }}" class="{{ $baseClass }} {{ $currentRoute === 'vendor.dashboard' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('vendor.menu.index') }}" class="{{ $baseClass }} {{ str_starts_with($currentRoute, 'vendor.menu') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Menu Saya
                    </a>
                    <a href="{{ route('vendor.distribusi.index') }}" class="{{ $baseClass }} {{ str_starts_with($currentRoute, 'vendor.distribusi') && $currentRoute !== 'vendor.distribusi.riwayat' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Distribusi
                    </a>
                    <a href="{{ route('vendor.distribusi.riwayat') }}" class="{{ $baseClass }} {{ $currentRoute === 'vendor.distribusi.riwayat' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat
                    </a>
                    <a href="{{ route('profile.edit') }}" class="{{ $baseClass }} {{ $currentRoute === 'profile.edit' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile Saya
                    </a>
                @elseif($role === 'sekolah')
                    <a href="{{ route('sekolah.dashboard') }}" class="{{ $baseClass }} {{ $currentRoute === 'sekolah.dashboard' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('sekolah.distributions.index') }}" class="{{ $baseClass }} {{ str_starts_with($currentRoute, 'sekolah.distributions') ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Pengiriman
                    </a>
                    <a href="{{ route('profile.edit') }}" class="{{ $baseClass }} {{ $currentRoute === 'profile.edit' ? $activeClass : $inactiveClass }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile Saya
                    </a>
                @endif
            </nav>

            <!-- User Profile (Bottom) -->
            <div class="p-6 border-t border-emerald-800/50 bg-emerald-950/30">
                <a href="{{ in_array($role, ['vendor', 'sekolah']) ? route('profile.edit') : '#' }}" class="flex items-center mb-4 group cursor-pointer">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-black/20 group-hover:scale-110 transition-transform duration-200">
                        <span class="text-white text-xs font-black">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-black text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">{{ auth()->user()->role->label() }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-xs font-black text-emerald-100/50 hover:text-white border border-emerald-800/50 hover:border-emerald-500 rounded-lg transition-all duration-200 uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0 z-10">
                <h1 class="text-xl font-black text-gray-800 tracking-tight uppercase">@yield('title')</h1>
                <div class="flex items-center gap-4">
                    <div class="h-8 w-px bg-gray-100"></div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ now()->format('d M Y') }}</span>
                </div>
            </header>

            <!-- Alerts -->
            <div class="overflow-y-auto flex-1 custom-scrollbar">
                @if(session('success'))
                <div class="mx-8 mt-6">
                    <div class="flex items-center p-4 text-sm font-bold text-emerald-700 bg-emerald-50 rounded-xl border border-emerald-100 shadow-sm animate-fade-in" role="alert">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mx-8 mt-6">
                    <div class="flex items-center p-4 text-sm font-bold text-red-700 bg-red-50 rounded-xl border border-red-100 shadow-sm animate-fade-in" role="alert">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                @endif

                <!-- Content -->
                <div class="p-8">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.style.transition = 'opacity 0.5s, transform 0.5s';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>
</html>
