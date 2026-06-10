@extends('layouts.sidebar')

@section('title', 'Distributions')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('vendor.distribusi.create') }}"
       class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl inline-flex items-center gap-2 shadow-sm transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Input Pengiriman Baru
    </a>
</div>

@if(session('success'))
<div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl border border-green-200 flex items-center gap-2">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                <th scope="col" class="px-6 py-4 font-semibold">Sekolah</th>
                <th scope="col" class="px-6 py-4 font-semibold">Porsi</th>
                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                <th scope="col" class="px-6 py-4 font-semibold">Komplain/Catatan</th>
                <th scope="col" class="px-6 py-4 font-semibold text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
            @forelse($distribusis as $d)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                    {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}
                </td>

                <td class="px-6 py-4 text-gray-900 font-medium">
                    {{ $d->sekolah_tujuan }}
                </td>

                <td class="px-6 py-4 text-gray-700 font-semibold">
                    {{ $d->jumlah_porsi }} Porsi
                </td>

                <td class="px-6 py-4">
                    @if($d->status === 'Pending')
                        <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">
                            Pending
                        </span>
                    @elseif($d->status === 'Dikirim')
                        <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">
                            Dikirim
                        </span>
                    @elseif($d->status === 'Diterima')
                        <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full border border-green-100">
                            Diterima
                        </span>
                    @elseif($d->status === 'Diterima Sebagian')
                        <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full border border-blue-100">
                            Diterima Sebagian
                        </span>
                    @else
                        <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">
                            {{ $d->status }}
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4">
                    @if($d->status === 'Diterima Sebagian' || $d->status === 'Komplain')
                        @forelse($d->feedbacks as $f)
                            <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-100 mb-1 last:mb-0">{{ $f->catatan }}</p>
                        @empty
                            <span class="text-gray-400 text-xs italic">Menunggu feedback...</span>
                        @endforelse
                    @else
                        <span class="text-gray-400 text-xs">-</span>
                    @endif
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('vendor.distribusi.edit', $d->id) }}"
                           class="bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-all">
                            Edit
                        </a>

                        <form action="{{ route('vendor.distribusi.destroy', $d->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin mau hapus?')"
                                class="bg-red-50 text-red-700 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-bold transition-all">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-lg font-medium text-gray-500">Belum ada data distribusi.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($distribusis->hasPages())
<div class="mt-6">
    {{ $distribusis->links() }}
</div>
@endif
@endsection
