@extends('layouts.sidebar')

@section('title', 'All Distributions')

@section('content')
<div class="mb-8 p-8 bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Status Semua Distribusi</h2>
            <p class="text-gray-500 mt-1 font-medium">Daftar lengkap riwayat distribusi gizi sekolah sebagai audit trail logistik.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.export') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-2.5 px-6 rounded-xl text-xs uppercase tracking-widest inline-flex items-center justify-center shadow-lg shadow-emerald-200/50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                    </path>
                </svg>
                Export PDF
            </a>
            <a href="{{ route('admin.reports.export_excel') }}"
               class="bg-green-600 hover:bg-green-700 text-white font-black py-2.5 px-6 rounded-xl text-xs uppercase tracking-widest inline-flex items-center justify-center shadow-lg shadow-green-200/50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                    </path>
                </svg>
                Export Excel
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl border border-emerald-100 bg-emerald-50 text-emerald-700 flex items-center gap-3 animate-fade-in shadow-sm">
    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    </div>
    <span class="font-bold text-sm">{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-xl border border-rose-100 bg-rose-50 text-rose-700 animate-fade-in shadow-sm">
    <div class="flex items-center gap-3 mb-2">
        <div class="w-8 h-8 bg-rose-500 rounded-lg flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <p class="font-black text-sm uppercase tracking-tight">Terjadi kesalahan:</p>
    </div>
    <ul class="list-disc list-inside text-sm font-medium ml-11">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50/80 font-bold">
                <tr>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Tanggal</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Vendor</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Sekolah</th>
                    <th scope="col" class="px-8 py-4 text-center whitespace-nowrap">Porsi</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Status</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Catatan</th>
                    <th scope="col" class="px-8 py-4 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($distributions as $d)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap text-gray-800 font-bold">
                        {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}
                    </td>

                    <td class="px-8 py-5 text-gray-800 font-black">
                        {{ $d->vendor->name ?? '-' }}
                    </td>

                    <td class="px-8 py-5 text-gray-800 font-black">
                        {{ $d->sekolah_tujuan }}
                    </td>

                    <td class="px-8 py-5 text-center">
                        <span class="inline-flex items-center px-3 py-1 bg-gray-50 text-gray-800 font-black rounded-lg border border-gray-200">
                            {{ $d->jumlah_porsi }}
                        </span>
                    </td>

                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $statusMap = [
                                'Pending' => ['color' => 'amber', 'icon' => 'clock'],
                                'Dikirim' => ['color' => 'blue', 'icon' => 'truck'],
                                'Di Perjalanan' => ['color' => 'blue', 'icon' => 'truck'],
                                'Diterima' => ['color' => 'emerald', 'icon' => 'check'],
                                'Diterima Sebagian' => ['color' => 'orange', 'icon' => 'alert'],
                                'Komplain' => ['color' => 'red', 'icon' => 'x'],
                                'Kendala' => ['color' => 'rose', 'icon' => 'x'],
                            ];
                            $cfg = $statusMap[$d->status] ?? ['color' => 'gray', 'icon' => 'dot'];
                        @endphp
                        <span class="inline-flex items-center bg-{{ $cfg['color'] }}-50 text-{{ $cfg['color'] }}-700 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full border border-{{ $cfg['color'] }}-100">
                            <span class="w-1.5 h-1.5 rounded-full mr-2 bg-current opacity-70"></span>
                            {{ $d->status }}
                        </span>
                    </td>

                    <td class="px-8 py-5">
                        @if($d->requestChanges->isNotEmpty())
                            <div class="space-y-1">
                                @foreach($d->requestChanges as $rc)
                                    <div class="text-[11px] font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-100 line-clamp-2" title="{{ $rc->alasan }}">
                                        {{ $rc->alasan }}
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs">-</span>
                        @endif
                    </td>

                    <td class="px-8 py-5 text-center">
                        <div class="flex justify-center items-center gap-2">
                            <button type="button"
                                    data-modal-target="reviseModal-{{ $d->id }}"
                                    data-modal-toggle="reviseModal-{{ $d->id }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    title="Revisi Data">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <button type="button"
                                    data-modal-target="cancelModal-{{ $d->id }}"
                                    data-modal-toggle="cancelModal-{{ $d->id }}"
                                    class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                    title="Batalkan Pengiriman">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Include Modals inside loop --}}
                @include('admin.distributions._modals', ['d' => $d])

                @empty
                <tr>
                    <td colspan="7" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-lg font-bold text-gray-500 tracking-tight">Belum ada riwayat distribusi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($distributions->hasPages())
    <div class="px-8 py-6 border-t border-gray-100 bg-gray-50/30">
        {{ $distributions->links() }}
    </div>
    @endif
</div>
@endsection
