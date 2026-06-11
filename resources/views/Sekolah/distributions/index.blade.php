@extends('layouts.sidebar')

@section('title', 'Status Pengiriman')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4 flex-wrap">
    <!-- Tabs -->
    <div class="flex bg-gray-100 p-1 rounded-xl w-fit">
        <a href="{{ route('sekolah.distributions.index') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $tab !== 'history' ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            Pengiriman Aktif
        </a>
        <a href="{{ route('sekolah.distributions.index', ['tab' => 'history']) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $tab === 'history' ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
            Riwayat Pengiriman
        </a>
    </div>

    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-blue-200">
        Sekolah Dashboard
    </span>
</div>

@if(session('success'))
<div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl border border-green-200 flex items-center gap-2">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-xl border border-red-200 flex items-center gap-2">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
    <span class="font-medium text-sm">{{ session('error') }}</span>
</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                <th scope="col" class="px-6 py-4 font-semibold">Vendor</th>
                <th scope="col" class="px-6 py-4 font-semibold">Menu</th>
                <th scope="col" class="px-6 py-4 font-semibold">Porsi</th>
                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                <th scope="col" class="px-6 py-4 font-semibold">Komplain/Catatan</th>
                <th scope="col" class="px-6 py-4 font-semibold text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($distributions as $d)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                    {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900">
                    {{ $d->vendor->name ?? 'Vendor Tidak Diketahui' }}
                </td>
                <td class="px-6 py-4 text-gray-600">
                    {{ $d->menu->name ?? 'Menu Tidak Tersedia' }}
                </td>
                <td class="px-6 py-4 font-semibold text-gray-700">
                    {{ $d->jumlah_porsi }} Porsi
                </td>
                <td class="px-6 py-4">
                    @if($d->status === 'Dikirim')
                        <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">
                            {{ $d->status }}
                        </span>
                    @elseif($d->status === 'Diterima')
                        <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full border border-green-100">
                            {{ $d->status }}
                        </span>
                    @elseif($d->status === 'Komplain')
                        <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">
                            {{ $d->status }}
                        </span>
                    @else
                        <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">
                            {{ $d->status }}
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($d->status === 'Komplain' || $d->status === 'Diterima Sebagian')
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
                    <div class="flex flex-col items-center gap-2">
                        @if($d->status === 'Dikirim')
                            <form action="{{ route('sekolah.distributions.update', $d) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="terima">
                                <button type="submit" dusk="terima-sesuai-{{ $d->id }}" class="w-full text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center transition-all">
                                    Terima Sesuai
                                </button>
                            </form>

                            <!-- PBI-38: Complaint Button -->
                            <button data-modal-target="complaint-modal-{{ $d->id }}" data-modal-toggle="complaint-modal-{{ $d->id }}"
                                    dusk="btn-komplain-{{ $d->id }}"
                                    class="w-full text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center transition-all" type="button">
                                Komplain
                            </button>

                            <!-- PBI-38: Flowbite Modal -->
                            <div id="complaint-modal-{{ $d->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                            <h3 class="text-lg font-bold text-gray-900">
                                                Ajukan Komplain
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="complaint-modal-{{ $d->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <form class="p-4 md:p-5" action="{{ route('sekolah.distributions.update', $d) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="terima_catatan">
                                            <div class="mb-4">
                                                <label for="catatan-{{ $d->id }}" class="block mb-2 text-sm font-semibold text-gray-900 text-left">Deskripsi Masalah/Komplain</label>
                                                <textarea id="catatan-{{ $d->id }}" name="catatan" rows="4"
                                                          dusk="catatan-{{ $d->id }}"
                                                          class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-xl border border-gray-200 focus:ring-red-500 focus:border-red-500"
                                                          placeholder="Jelaskan kendala atau porsi yang tidak sesuai..." required></textarea>
                                            </div>
                                            <button type="submit" dusk="submit-komplain-{{ $d->id }}" class="w-full text-white inline-flex items-center justify-center bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-bold rounded-xl text-sm px-5 py-3 text-center transition-all">
                                                Kirim Komplain
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @elseif($d->status === 'Komplain')
                            <!-- PBI-38: Resolution Action -->
                            <form action="{{ route('sekolah.distributions.update', $d) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="resolve_komplain">
                                <button type="submit" dusk="resolve-komplain-{{ $d->id }}" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center transition-all">
                                    Tandai Selesai
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-xs italic">Sudah dikonfirmasi</span>
                        @endif
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
                        <p class="text-lg font-medium text-gray-500">
                            @if($tab === 'history')
                                Belum ada riwayat pengiriman.
                            @else
                                Belum ada distribusi aktif (Dikirim).
                            @endif
                        </p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($distributions->hasPages())
<div class="mt-6">
    {{ $distributions->links() }}
</div>
@endif

@endsection
