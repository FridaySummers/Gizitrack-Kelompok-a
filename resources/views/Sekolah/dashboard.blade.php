@extends('layouts.sidebar')

@section('title', 'Dashboard Sekolah')

@section('content')
<div class="mb-8 p-8 bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Halo, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-gray-500 mt-1 font-medium">Selamat datang kembali di panel monitoring gizi sekolah.</p>
        </div>
        <div class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full border border-emerald-100/50">
            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            Sistem Aktif
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-300">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">Monitoring</span>
        </div>
        <p class="text-xs text-gray-500 font-black uppercase tracking-widest">Pengiriman Aktif</p>
        <p class="text-4xl font-black text-gray-800 mt-2">{{ $pengirimanAktif }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors duration-300">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">Selesai</span>
        </div>
        <p class="text-xs text-gray-500 font-black uppercase tracking-widest">Total Diterima</p>
        <p class="text-4xl font-black text-gray-800 mt-2">{{ $totalDiterima }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center group-hover:bg-orange-100 transition-colors duration-300">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-orange-600 bg-orange-50 px-2.5 py-1 rounded-lg">Catatan</span>
        </div>
        <p class="text-xs text-gray-500 font-black uppercase tracking-widest">Total Komplain</p>
        <p class="text-4xl font-black text-gray-800 mt-2">{{ $totalKomplain }}</p>
    </div>
</div>

<!-- Recent Distributions Table -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
    <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
        <h3 class="font-black text-gray-800 text-lg uppercase tracking-tight">Distribusi Terbaru</h3>
        <a href="{{ route('sekolah.distributions.index') }}" class="text-xs font-black uppercase tracking-widest text-emerald-600 hover:text-emerald-700 transition-colors flex items-center gap-1 group">
            Lihat Semua <span class="group-hover:translate-x-1 transition-transform">→</span>
        </a>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-[10px] text-gray-400 uppercase bg-gray-50/80 font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Tanggal Pengiriman</th>
                    <th class="px-8 py-4">Nama Vendor</th>
                    <th class="px-8 py-4">Menu Makanan</th>
                    <th class="px-8 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($distribusiTerbaru as $d)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-4 whitespace-nowrap text-gray-800 font-bold">
                        {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}
                    </td>
                    <td class="px-8 py-4 font-medium">
                        {{ $d->vendor->name ?? '-' }}
                    </td>
                    <td class="px-8 py-4 font-medium">
                        {{ $d->menu->name ?? '-' }}
                    </td>
                    <td class="px-8 py-4">
                        @if($d->status === 'Dikirim')
                            <span class="inline-flex items-center bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-amber-100">
                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full mr-1.5"></span>
                                Dikirim
                            </span>
                        @elseif($d->status === 'Diterima')
                            <span class="inline-flex items-center bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-emerald-100">
                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5"></span>
                                Diterima
                            </span>
                        @elseif($d->status === 'Komplain')
                            <span class="inline-flex items-center bg-red-50 text-red-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-red-100">
                                <span class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></span>
                                Komplain
                            </span>
                        @else
                            <span class="inline-flex items-center bg-rose-50 text-rose-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-rose-100">
                                <span class="w-1.5 h-1.5 bg-rose-400 rounded-full mr-1.5"></span>
                                Kendala
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-16 text-center text-gray-400 font-medium">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">Belum ada data distribusi terbaru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
