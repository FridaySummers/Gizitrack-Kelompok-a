@extends('layouts.sidebar')

@section('title', 'Edit Distribusi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
        {{-- Header Form --}}
        <div class="p-8 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Revisi Data Distribusi</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">ID Transaksi: #{{ $distribusi->id }}</p>
                </div>
            </div>
        </div>

        {{-- Error Alerts --}}
        @if ($errors->any())
            <div class="mx-8 mt-8 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700 animate-fade-in">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="font-black text-xs uppercase tracking-widest">Validasi Gagal</p>
                </div>
                <ul class="list-disc list-inside text-sm font-medium ml-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendor.distribusi.update', $distribusi->id) }}" method="POST" class="p-8 space-y-6"
              x-data="{ porsiAwal: {{ $distribusi->jumlah_porsi }}, porsiBaru: {{ $distribusi->jumlah_porsi }} }">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tanggal --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tanggal Pengiriman</label>
                    <input type="date" name="tanggal_pengiriman"
                        value="{{ $distribusi->tanggal_pengiriman }}"
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold">
                </div>

                {{-- Status --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Status Logistik</label>
                    <select name="status" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold">
                        <option value="Pending" {{ $distribusi->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Dikirim" {{ $distribusi->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="Diterima" {{ $distribusi->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="Diterima Sebagian" {{ $distribusi->status == 'Diterima Sebagian' ? 'selected' : '' }}>Diterima Sebagian</option>
                        <option value="Komplain" {{ $distribusi->status == 'Komplain' ? 'selected' : '' }}>Komplain</option>
                        <option value="Kendala" {{ $distribusi->status == 'Kendala' ? 'selected' : '' }}>Kendala</option>
                    </select>
                </div>
            </div>

            {{-- Sekolah --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Institusi Tujuan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-1 4h1m2-8v2m0 2v2m0-2h2m-2 0H9"></path></svg>
                    </div>
                    <input type="text" name="sekolah_tujuan"
                        value="{{ $distribusi->sekolah_tujuan }}"
                        class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold">
                </div>
            </div>

            {{-- Tracking Data Section --}}
            <div class="p-6 bg-blue-50 rounded-2xl border border-blue-100 space-y-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <h3 class="text-xs font-black text-blue-800 uppercase tracking-widest">Data Live Tracking (GPS)</h3>
                </div>

                <p class="text-[10px] font-bold text-blue-600/70 uppercase tracking-tight">Perbarui koordinat pengiriman untuk memberikan transparansi lokasi kepada pihak sekolah secara real-time.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-600/70 uppercase tracking-widest ml-1">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $distribusi->latitude) }}"
                               placeholder="Contoh: -6.123456"
                               class="block w-full px-4 py-3 bg-white border border-blue-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-mono font-bold placeholder:text-blue-200">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-blue-600/70 uppercase tracking-widest ml-1">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $distribusi->longitude) }}"
                               placeholder="Contoh: 106.123456"
                               class="block w-full px-4 py-3 bg-white border border-blue-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none font-mono font-bold placeholder:text-blue-200">
                    </div>
                </div>
            </div>

            {{-- Porsi --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Volume Porsi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <input type="number" name="jumlah_porsi"
                        value="{{ $distribusi->jumlah_porsi }}"
                        x-model="porsiBaru"
                        class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-black text-lg">
                </div>

                {{-- Indikator perubahan porsi --}}
                <template x-if="porsiAwal != porsiBaru">
                    <div class="mt-3 p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-center gap-3 animate-fade-in">
                        <div class="w-6 h-6 bg-amber-500 rounded-lg flex items-center justify-center text-white shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                        <p class="text-[11px] font-bold text-amber-800 leading-tight">
                            Porsi diubah dari <span class="underline" x-text="porsiAwal"></span> menjadi <span class="underline" x-text="porsiBaru"></span>. Wajib mencantumkan alasan.
                        </p>
                    </div>
                </template>
            </div>

            {{-- Alasan Perubahan --}}
            <div x-show="porsiAwal != porsiBaru" x-cloak x-transition class="space-y-2">
                <label class="block text-[10px] font-black text-amber-600 uppercase tracking-widest ml-1">Justifikasi Perubahan</label>
                <textarea name="alasan_perubahan" rows="3"
                    placeholder="Contoh: Selisih persiapan dapur, bahan baku kurang 20 porsi..."
                    class="block w-full p-4 bg-amber-50/50 border border-amber-200 text-gray-800 text-sm rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none placeholder:text-amber-300 font-medium">{{ old('alasan_perubahan') }}</textarea>
            </div>

            {{-- Footer Buttons --}}
            <div class="pt-6 flex flex-col sm:flex-row gap-3">
                <button type="submit" class="flex-1 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    Simpan Perubahan
                </button>

                <a href="{{ route('vendor.distribusi.index') }}"
                   class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 font-black text-xs uppercase tracking-widest rounded-2xl transition-all text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
