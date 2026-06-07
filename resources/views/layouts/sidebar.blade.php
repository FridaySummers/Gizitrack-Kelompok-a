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
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col flex-shrink-0">
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <span class="text-2xl font-bold text-emerald-500">🌿</span>
                <span class="ml-2 text-xl font-bold text-emerald-500">GiziTrack</span>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                @php $role = auth()->user()->role->value; $currentRoute = request()->route()->getName(); @endphp

                @if($role === 'super_admin')
                {{-- Super Admin: Overview & Distributions IDENTIK dengan Admin --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ $currentRoute === 'admin.dashboard' ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Overview
                </a>
                <a href="{{ route('admin.distributions.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ str_starts_with($currentRoute, 'admin.distributions') ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Distributions
                </a>
                {{-- Hanya Manage Accounts yang berbeda --}}
                <a href="{{ route('super_admin.users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ str_starts_with($currentRoute, 'super_admin.users') ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Manage Accounts
                </a>
                @elseif($role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ $currentRoute === 'admin.dashboard' ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Overview
                </a>
                <a href="{{ route('admin.distributions.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ str_starts_with($currentRoute, 'admin.distributions') ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Distributions
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ str_starts_with($currentRoute, 'admin.users') ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Manage Accounts
                </a>
                @elseif($role === 'vendor')
                <a href="{{ route('vendor.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ $currentRoute === 'vendor.dashboard' ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Dashboard
                </a>
                <a href="{{ route('vendor.menu.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ str_starts_with($currentRoute, 'vendor.menu') ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Menu Saya
                </a>
                <a href="{{ route('vendor.distribusi.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ str_starts_with($currentRoute, 'vendor.distribusi') && $currentRoute !== 'vendor.distribusi.riwayat' ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Distribusi
                </a>
                <a href="{{ route('vendor.distribusi.riwayat') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ $currentRoute === 'vendor.distribusi.riwayat' ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Riwayat Pengiriman
                </a>
                @elseif($role === 'sekolah')
                <a href="{{ route('sekolah.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ $currentRoute === 'sekolah.dashboard' ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Dashboard
                </a>
                <a href="{{ route('sekolah.distributions.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium {{ str_starts_with($currentRoute, 'sekolah.distributions') ? 'bg-emerald-50 text-emerald-700 border-l-2 border-emerald-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    Status Pengiriman
                </a>
                @endif
            </nav>

            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                    </div>
                    <div class="ml-2">
                        <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                        <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">{{ auth()->user()->role->label() }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-sm text-gray-500 hover:text-gray-700 px-2 py-1.5 rounded">Logout</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0">
                <h1 class="text-lg font-semibold text-gray-800">@yield('title')</h1>
            </header>

            @if(session('success'))
            <div class="mx-6 mt-4">
                <div class="flex items-center p-4 text-sm text-green-700 bg-green-50 rounded-lg border border-green-200" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-6 mt-4">
                <div class="flex items-center p-4 text-sm text-red-700 bg-red-50 rounded-lg border border-red-200" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif

            <div class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>
</html>
