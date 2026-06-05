@extends('layouts.sidebar')

@section('title', 'Monitor Status Dikirim')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Monitor Status "Dikirim"</h2>
        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">Sekolah Dashboard</span>
    </div>

    @if(session('success'))
    <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg>
        <span class="sr-only">Success</span>
        <div class="ms-3 text-sm font-medium">
            {{ session('success') }}
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-3" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Vendor</th>
                    <th scope="col" class="px-6 py-3">Menu</th>
                    <th scope="col" class="px-6 py-3">Porsi</th>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($distributions as $d)
                <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $d->vendor->name ?? 'Vendor Tidak Diketahui' }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $d->menu->name ?? 'Menu Tidak Tersedia' }}
                    </td>
                    <td class="px-6 py-4 font-semibold">
                        {{ $d->jumlah_porsi }} Porsi
                    </td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d F Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($d->status === 'Dikirim')
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-yellow-300">
                            {{ $d->status }}
                        </span>
                        @else
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-gray-300">
                            {{ $d->status }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($d->status === 'Dikirim')
                        <form action="{{ route('sekolah.distributions.update', $d) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="terima">
                            <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center transition-all">
                                Terima Sesuai
                            </button>
                        </form>

                        <!-- PBI-38: Modal Trigger Button -->
                        <button data-modal-target="complaint-modal-{{ $d->id }}" data-modal-toggle="complaint-modal-{{ $d->id }}" class="mt-1 block w-full text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-2 py-1 text-center transition-all" type="button">
                            Terima dengan Catatan
                        </button>

                        <!-- PBI-38: Flowbite Modal -->
                        <div id="complaint-modal-{{ $d->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow">
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Kirim Catatan / Komplain
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
                                        <div class="grid gap-4 mb-4 grid-cols-2">
                                            <div class="col-span-2 text-left">
                                                <label for="catatan-{{ $d->id }}" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi Catatan</label>
                                                <textarea id="catatan-{{ $d->id }}" name="catatan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis alasan terima sebagian atau komplain di sini..." required></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Simpan & Konfirmasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="bg-white">
                    <td colspan="5" class="px-6 py-10 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-lg">Belum ada distribusi dengan status "Dikirim"</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $distributions->links() }}
    </div>
</div>
@endsection
