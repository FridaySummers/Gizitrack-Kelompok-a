@extends('layouts.sidebar')

@section('title', 'Status Pengiriman')

@section('content')
<div class="mb-8 p-8 bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Monitoring Distribusi</h2>
            <p class="text-gray-500 mt-1 font-medium text-sm">Konfirmasi penerimaan atau ajukan komplain terkait pengiriman makanan hari ini.</p>
        </div>

        <div class="flex bg-gray-50 p-1.5 rounded-xl border border-gray-100 shadow-inner">
            <a href="{{ route('sekolah.distributions.index') }}"
               class="px-5 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest transition-all {{ $tab !== 'history' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-400 hover:text-emerald-600' }}">
                Pengiriman Aktif
            </a>
            <a href="{{ route('sekolah.distributions.index', ['tab' => 'history']) }}"
               class="px-5 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest transition-all {{ $tab === 'history' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-400 hover:text-emerald-600' }}">
                Riwayat Data
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

@if(session('error'))
<div class="mb-6 p-4 rounded-xl border border-rose-100 bg-rose-50 text-rose-700 flex items-center gap-3 animate-fade-in shadow-sm">
    <div class="w-8 h-8 bg-rose-500 rounded-lg flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
    </div>
    <span class="font-bold text-sm">{{ session('error') }}</span>
</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-[10px] text-gray-400 uppercase bg-gray-50/80 font-black tracking-widest">
                <tr>
                    <th scope="col" class="px-8 py-4">Tanggal</th>
                    <th scope="col" class="px-8 py-4">Pihak Vendor</th>
                    <th scope="col" class="px-8 py-4">Menu Makanan</th>
                    <th scope="col" class="px-8 py-4 text-center">Volume</th>
                    <th scope="col" class="px-8 py-4">Status</th>
                    <th scope="col" class="px-8 py-4">Catatan/Komplain</th>
                    <th scope="col" class="px-8 py-4 text-center">Konfirmasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($distributions as $d)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap text-gray-800 font-bold">
                        {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-gray-900 font-black group-hover:text-emerald-600 transition-colors">{{ $d->vendor->name ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="font-medium text-gray-500">{{ $d->menu->name ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="inline-flex items-center px-3 py-1 bg-gray-50 text-gray-800 font-black rounded-lg border border-gray-200">
                            {{ $d->jumlah_porsi }}
                        </span>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'Dikirim' => 'amber',
                                'Diterima' => 'emerald',
                                'Komplain' => 'red',
                                'Kendala' => 'rose'
                            ];
                            $clr = $statusColors[$d->status] ?? 'gray';
                        @endphp
                        <span class="inline-flex items-center bg-{{ $clr }}-50 text-{{ $clr }}-700 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full border border-{{ $clr }}-100">
                            <span class="w-1.5 h-1.5 rounded-full mr-2 bg-current opacity-70"></span>
                            {{ $d->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 max-w-xs">
                        @if($d->status === 'Komplain' || $d->status === 'Diterima Sebagian')
                            @forelse($d->feedbacks as $f)
                                <div class="text-[11px] font-bold text-rose-600 bg-rose-50 px-2.5 py-2 rounded-lg border border-rose-100 mb-1 last:mb-0 leading-relaxed">
                                    {{ $f->catatan }}
                                </div>
                            @empty
                                <span class="text-gray-400 text-[11px] italic font-medium">Menunggu feedback vendor...</span>
                            @endforelse
                        @else
                            <span class="text-gray-300 text-xs italic">-</span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-3">
                            @if($d->latitude && $d->longitude)
                                <a href="https://www.google.com/maps?q={{ $d->latitude }},{{ $d->longitude }}" target="_blank"
                                   class="p-2.5 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100 group-hover:scale-110"
                                   title="Lacak Lokasi Kurir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </a>
                            @endif

                            @if($d->status === 'Dikirim')
                                <form action="{{ route('sekolah.distributions.update', $d) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="terima">
                                    <button type="submit" dusk="terima-sesuai-{{ $d->id }}"
                                            class="p-2.5 text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded-xl transition-all shadow-sm border border-emerald-100 group-hover:scale-110"
                                            title="Konfirmasi Terima Sesuai">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>

                                <button data-modal-target="complaint-modal-{{ $d->id }}" data-modal-toggle="complaint-modal-{{ $d->id }}"
                                        dusk="btn-komplain-{{ $d->id }}"
                                        class="p-2.5 text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm border border-rose-100 group-hover:scale-110"
                                        type="button" title="Ajukan Komplain">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </button>

                                <!-- Flowbite Modal -->
                                <div id="complaint-modal-{{ $d->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                                            <div class="flex items-center justify-between p-6 border-b border-gray-50 bg-gray-50/50">
                                                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">
                                                    Ajukan Komplain
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="complaint-modal-{{ $d->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close</span>
                                                </button>
                                            </div>
                                            <form class="p-6" action="{{ route('sekolah.distributions.update', $d) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="terima_catatan">
                                                <div class="mb-6">
                                                    <label for="catatan-{{ $d->id }}" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left ml-1">Deskripsi Masalah</label>
                                                    <textarea id="catatan-{{ $d->id }}" name="catatan" rows="4"
                                                              dusk="catatan-{{ $d->id }}"
                                                              class="block p-4 w-full text-sm text-gray-900 bg-gray-50 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none placeholder:text-gray-400"
                                                              placeholder="Jelaskan kendala atau porsi yang tidak sesuai..." required></textarea>
                                                </div>
                                                <button type="submit" dusk="submit-komplain-{{ $d->id }}" class="w-full text-white inline-flex items-center justify-center bg-rose-600 hover:bg-rose-700 shadow-lg shadow-rose-200 focus:ring-4 focus:outline-none focus:ring-rose-300 font-black uppercase tracking-widest rounded-2xl text-xs px-5 py-4 text-center transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                                                    Kirim Komplain
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @elseif($d->status === 'Komplain')
                                <form action="{{ route('sekolah.distributions.update', $d) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="resolve_komplain">
                                    <button type="submit" dusk="resolve-komplain-{{ $d->id }}"
                                            class="p-2.5 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-sm border border-blue-100 group-hover:scale-110"
                                            title="Tandai Masalah Selesai">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">Confirmed</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-lg font-bold text-gray-500 tracking-tight">
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
</div>

@if($distributions->hasPages())
<div class="mt-8">
    {{ $distributions->links() }}
</div>
@endif

@endsection
