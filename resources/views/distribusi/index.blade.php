@extends('layouts.sidebar')

@section('title', 'Daftar Distribusi')

@section('content')
<div class="mb-8 p-8 bg-white rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between gap-4 flex-wrap transition-all duration-300 hover:shadow-md">
    <div>
        <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Kelola Pengiriman</h2>
        <p class="text-gray-500 mt-1 font-medium">Pantau dan kelola status pengiriman makanan ke sekolah tujuan.</p>
    </div>

    <a href="{{ route('vendor.distribusi.create') }}"
       class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-2.5 px-6 rounded-xl text-xs uppercase tracking-widest inline-flex items-center gap-2 shadow-lg shadow-emerald-200/50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Input Pengiriman Baru
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl border border-emerald-100 bg-emerald-50 text-emerald-700 flex items-center gap-3 animate-fade-in shadow-sm">
    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    </div>
    <span class="font-bold text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50/80 font-bold">
                <tr>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Tanggal</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Sekolah</th>
                    <th scope="col" class="px-8 py-4 text-center whitespace-nowrap">Porsi</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Status</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Komplain/Catatan</th>
                    <th scope="col" class="px-8 py-4 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($distribusis as $d)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap text-gray-900 font-bold">
                        {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}
                    </td>

                    <td class="px-8 py-5 text-gray-900 font-black">
                        {{ $d->sekolah_tujuan }}
                    </td>

                    <td class="px-8 py-5 text-center">
                        <span class="inline-flex items-center px-3 py-1 bg-gray-50 text-gray-900 font-black rounded-lg border border-gray-200">
                            {{ $d->jumlah_porsi }}
                        </span>
                    </td>

                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $statusMap = [
                                'Pending' => ['color' => 'amber'],
                                'Dikirim' => ['color' => 'blue'],
                                'Diterima' => ['color' => 'emerald'],
                                'Diterima Sebagian' => ['color' => 'orange'],
                                'Komplain' => ['color' => 'red'],
                                'Kendala' => ['color' => 'rose'],
                            ];
                            $cfg = $statusMap[$d->status] ?? ['color' => 'gray'];
                        @endphp
                        <span class="inline-flex items-center bg-{{ $cfg['color'] }}-50 text-{{ $cfg['color'] }}-700 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full border border-{{ $cfg['color'] }}-100">
                            <span class="w-1.5 h-1.5 rounded-full mr-2 bg-current opacity-70"></span>
                            {{ $d->status }}
                        </span>
                    </td>

                    <td class="px-8 py-5">
                        @if($d->status === 'Komplain' || $d->status === 'Kendala')
                            <div class="p-3 rounded-lg bg-rose-50 border border-rose-100 text-rose-700 text-xs font-bold leading-relaxed max-w-xs">
                                {{ $d->catatan_kendala ?? 'Ada kendala pada pengiriman ini.' }}
                            </div>
                        @elseif($d->requestChanges->isNotEmpty())
                            <div class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-100 inline-block">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Ada Revisi Data
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs">Tidak ada catatan</span>
                        @endif
                    </td>

                    <td class="px-8 py-5 text-center">
                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('vendor.distribusi.edit', $d->id) }}"
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors group-hover:scale-110"
                               title="Edit Data">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>

                            <form action="{{ route('vendor.distribusi.destroy', $d->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors group-hover:scale-110"
                                        title="Hapus Data">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-lg font-bold text-gray-500 tracking-tight">Belum ada data distribusi.</p>
                            <p class="text-sm text-gray-400 mt-1">Klik tombol di atas untuk membuat pengiriman baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($distribusis->hasPages())
    <div class="px-8 py-6 border-t border-gray-100 bg-gray-50/30">
        {{ $distribusis->links() }}
    </div>
    @endif
</div>
@endsection
