@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Selamat Datang, Vendor!</h2>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Menu</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Menu::count() }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Distribusi</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Distribusi::count() }}</p>
            </div>
            <div class="w-12 h-12 bg-cyan-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <a href="{{ route('vendor.menu.index') }}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:border-emerald-200 transition">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <div>
                <h3 class="font-medium text-gray-800">Kelola Menu</h3>
                <p class="text-sm text-gray-500">Tambah, edit, atau hapus menu</p>
            </div>
        </div>
    </a>

    <a href="{{ route('vendor.distribusi.index') }}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:border-emerald-200 transition">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h3 class="font-medium text-gray-800">Kelola Distribusi</h3>
                <p class="text-sm text-gray-500">Input pengiriman makanan</p>
            </div>
        </div>
    </a>
</div>
@endsection
