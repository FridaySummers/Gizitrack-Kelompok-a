@extends('layouts.sidebar')

@section('title', 'Tambah Distribusi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
        {{-- Header Form --}}
        <div class="p-8 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Input Distribusi Baru</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Daftarkan pengiriman makanan harian ke sekolah tujuan.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('vendor.distribusi.store') }}" class="p-8 space-y-6">
            @csrf

            {{-- Institusi Tujuan --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Penerima Manfaat (Sekolah)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-1 4h1m2-8v2m0 2v2m0-2h2m-2 0H9"></path></svg>
                    </div>
                    <input type="text" name="sekolah_tujuan" placeholder="Contoh: SDN 01 Pagi Jakarta" required
                           class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold placeholder:text-gray-300">
                </div>
                @error('sekolah_tujuan')
                    <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Volume Porsi --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Kuantitas (Porsi)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <input type="number" name="jumlah_porsi" placeholder="0" required
                               class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-black text-lg">
                    </div>
                    @error('jumlah_porsi')
                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jadwal Pengiriman</label>
                    <input type="date" name="tanggal_pengiriman" value="{{ now()->toDateString() }}" required
                           class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold">
                    @error('tanggal_pengiriman')
                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Status Otomatis --}}
            <input type="hidden" name="status" value="Dikirim">

            {{-- Tracking Data Section --}}
            <div class="p-6 bg-blue-50 rounded-2xl border border-blue-100 space-y-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <h3 class="text-xs font-black text-blue-800 uppercase tracking-widest">Inisialisasi Live Tracking (GPS)</h3>
                </div>

                <p class="text-[10px] font-bold text-blue-600/70 uppercase tracking-tight">Opsional: Masukkan koordinat awal pengiriman untuk aktivasi sistem monitoring real-time.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-600/70 uppercase tracking-widest ml-1">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude') }}"
                               placeholder="Contoh: -6.123456"
                               class="block w-full px-4 py-3 bg-white border border-blue-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-mono font-bold placeholder:text-blue-200">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-600/70 uppercase tracking-widest ml-1">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude') }}"
                               placeholder="Contoh: 106.123456"
                               class="block w-full px-4 py-3 bg-white border border-blue-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-mono font-bold placeholder:text-blue-200">
                    </div>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="pt-6 flex flex-col sm:flex-row gap-3">
                <button type="submit" class="flex-1 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    Inisiasi Pengiriman
                </button>

                <a href="{{ route('vendor.distribusi.index') }}"
                   class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 font-black text-xs uppercase tracking-widest rounded-2xl transition-all text-center">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
