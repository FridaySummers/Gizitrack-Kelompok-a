@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
        <div class="p-8 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Sistem Terverifikasi</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Anda telah berhasil masuk ke dalam ekosistem GiziTrack.</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <p class="text-gray-600 font-medium leading-relaxed">
                Selamat datang, <span class="text-gray-900 font-black">{{ auth()->user()->name }}</span>.
                Anda saat ini memiliki akses sebagai <span class="text-emerald-600 font-black uppercase tracking-widest text-xs px-2 py-1 bg-emerald-50 rounded-lg border border-emerald-100">{{ auth()->user()->role->label() }}</span>.
            </p>
            <div class="mt-6 p-4 bg-blue-50 rounded-2xl border border-blue-100 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-xs font-bold text-blue-800 leading-relaxed">
                    Gunakan bilah navigasi di samping kiri untuk mengelola data distribusi, inventaris menu, atau memantau laporan real-time sesuai dengan otoritas akun Anda.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
