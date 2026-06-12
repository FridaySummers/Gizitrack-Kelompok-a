@extends('layouts.sidebar')

@section('title', 'Riwayat Pengiriman Harian')

@section('content')

{{-- Header & Date Picker --}}
<div class="mb-8 p-8 bg-white rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between gap-6 flex-wrap transition-all duration-300 hover:shadow-md">
    <div>
        <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Pelacakan Pengiriman</h2>
        <p class="text-gray-500 mt-1 font-medium italic">
            {{ \Carbon\Carbon::parse($tanggal)->format('l, d F Y') }}
        </p>
    </div>

    <div class="flex items-center gap-3 bg-gray-50 p-1.5 rounded-xl border border-gray-100">
        {{-- Tombol Kemarin --}}
        <a href="{{ route('vendor.distribusi.riwayat', ['tanggal' => \Carbon\Carbon::parse($tanggal)->subDay()->toDateString()]) }}"
           class="p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all text-gray-500 hover:text-emerald-600"
           title="Hari sebelumnya">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        {{-- Date Input --}}
        <form id="dateForm" method="GET" action="{{ route('vendor.distribusi.riwayat') }}">
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                   onchange="document.getElementById('dateForm').submit()"
                   class="bg-transparent border-none text-sm font-black text-gray-700 focus:ring-0 px-2 py-1 cursor-pointer">
        </form>

        {{-- Tombol Hari Ini --}}
        <a href="{{ route('vendor.distribusi.riwayat', ['tanggal' => now()->toDateString()]) }}"
           class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all
                  {{ $tanggal === now()->toDateString() ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200/50' : 'text-gray-500 hover:bg-white hover:text-emerald-600' }}">
            Hari Ini
        </a>

        {{-- Tombol Besok --}}
        <a href="{{ route('vendor.distribusi.riwayat', ['tanggal' => \Carbon\Carbon::parse($tanggal)->addDay()->toDateString()]) }}"
           class="p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all text-gray-500 hover:text-emerald-600"
           title="Hari berikutnya">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>

{{-- Summary Stats --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    {{-- Total --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total</p>
        <p class="text-2xl font-black text-gray-800">{{ $summary['total_pengiriman'] }}</p>
        <p class="text-[10px] font-bold text-gray-500 mt-1">Pengiriman</p>
    </div>

    {{-- Porsi --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Volume</p>
        <p class="text-2xl font-black text-emerald-600">{{ number_format($summary['total_porsi']) }}</p>
        <p class="text-[10px] font-bold text-gray-500 mt-1">Total Porsi</p>
    </div>

    {{-- Diterima --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border-b-4 border-b-emerald-500">
        <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">Berhasil</p>
        <p class="text-2xl font-black text-gray-800">{{ $summary['diterima'] }}</p>
        <p class="text-[10px] font-bold text-gray-500 mt-1">Diterima</p>
    </div>

    {{-- Dikirim --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border-b-4 border-b-blue-500">
        <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-2">Proses</p>
        <p class="text-2xl font-black text-gray-800">{{ $summary['dikirim'] }}</p>
        <p class="text-[10px] font-bold text-gray-500 mt-1">Dalam Perjalanan</p>
    </div>

    {{-- Pending --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border-b-4 border-b-amber-500">
        <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-2">Antrian</p>
        <p class="text-2xl font-black text-gray-800">{{ $summary['pending'] }}</p>
        <p class="text-[10px] font-bold text-gray-500 mt-1">Belum Jalan</p>
    </div>

    {{-- Kendala --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border-b-4 border-b-rose-500">
        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest mb-2">Masalah</p>
        <p class="text-2xl font-black text-rose-600">{{ $summary['kendala'] }}</p>
        <p class="text-[10px] font-bold text-gray-500 mt-1">Komplain/Gagal</p>
    </div>
</div>

{{-- Main List --}}
<div class="space-y-4">
    @forelse($distribusis as $d)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-wrap items-center gap-6 transition-all duration-300 hover:shadow-md hover:border-emerald-100 group relative overflow-hidden">
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-{{ $d->status === 'Diterima' ? 'emerald' : ($d->status === 'Dikirim' ? 'blue' : ($d->status === 'Pending' ? 'amber' : 'rose')) }}-500"></div>

        {{-- Time --}}
        <div class="shrink-0 text-center px-4">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu Update</p>
            <p class="text-lg font-black text-gray-800">{{ $d->updated_at->format('H:i') }}</p>
        </div>

        {{-- Destination --}}
        <div class="flex-1 min-w-[200px]">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Tujuan</span>
                <span class="text-xs font-bold text-gray-400">#{{ $d->id }}</span>
            </div>
            <h3 class="text-lg font-black text-gray-800 group-hover:text-emerald-600 transition-colors uppercase tracking-tight">{{ $d->sekolah_tujuan }}</h3>
            <p class="text-sm font-medium text-gray-500 mt-1 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Menu: <span class="font-bold text-gray-700">{{ $d->menu->name ?? '-' }}</span>
            </p>
        </div>

        {{-- Stats --}}
        <div class="shrink-0 flex items-center gap-8 px-6 border-x border-gray-50">
            <div class="text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Jumlah</p>
                <p class="text-xl font-black text-gray-800">{{ $d->jumlah_porsi }} <span class="text-xs font-bold text-gray-400">Porsi</span></p>
            </div>
            <div class="text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status</p>
                @php
                    $statusColors = [
                        'Pending' => 'amber',
                        'Dikirim' => 'blue',
                        'Diterima' => 'emerald',
                        'Diterima Sebagian' => 'orange',
                        'Komplain' => 'red',
                        'Kendala' => 'rose'
                    ];
                    $clr = $statusColors[$d->status] ?? 'gray';
                @endphp
                <span class="inline-flex items-center bg-{{ $clr }}-50 text-{{ $clr }}-700 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full border border-{{ $clr }}-100">
                    {{ $d->status }}
                </span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="shrink-0 flex items-center gap-2">
            @if($d->latitude && $d->longitude)
            <a href="https://www.google.com/maps?q={{ $d->latitude }},{{ $d->longitude }}" target="_blank"
               class="p-3 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm"
               title="Lihat Lokasi Terakhir">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </a>
            @endif

            <a href="{{ route('vendor.distribusi.edit', $d->id) }}"
               class="p-3 bg-gray-50 text-gray-500 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm"
               title="Edit Status/Laporan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </a>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-16 text-center">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <h3 class="text-lg font-black text-gray-800 tracking-tight uppercase">Tidak Ada Pengiriman</h3>
        <p class="text-sm font-medium text-gray-500 mt-1 max-w-xs mx-auto">Belum ada data distribusi makanan yang tercatat untuk tanggal yang dipilih.</p>
        <a href="{{ route('vendor.distribusi.create') }}" class="mt-6 inline-flex items-center gap-2 text-emerald-600 font-black text-xs uppercase tracking-widest hover:underline">
            Mulai Pengiriman Baru →
        </a>
    </div>
    @endforelse
</div>

@endsection
