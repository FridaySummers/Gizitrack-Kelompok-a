<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @if(session()->has('impersonator_id'))
        <div class="fixed top-0 left-0 right-0 z-[100] bg-amber-500/90 backdrop-blur-md text-amber-950 px-6 py-3 shadow-2xl border-b border-amber-600/20">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-xl">⚠️</span>
                    <p class="text-sm font-black uppercase tracking-tight">
                        Mode Impersonasi: Anda sedang masuk sebagai <span class="underline decoration-2 underline-offset-4">{{ auth()->user()->name }}</span>.
                        <span class="hidden md:inline opacity-75 font-bold ml-2">Segala tindakan akan dicatat atas nama akun ini.</span>
                    </p>
                </div>
                <a href="{{ route('impersonate.leave') }}"
                   class="bg-amber-950 text-white hover:bg-black px-5 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all transform hover:scale-105 active:scale-95 shadow-lg shadow-amber-900/20 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Kembali ke Super Admin
                </a>
            </div>
        </div>
        @endif

        <div class="min-h-screen bg-gray-50 {{ session()->has('impersonator_id') ? 'pt-14' : '' }}">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
