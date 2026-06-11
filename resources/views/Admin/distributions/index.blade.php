@extends('layouts.sidebar')

@section('title', 'All Distributions')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4 flex-wrap">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Status Semua Distribusi</h2>
        <p class="text-gray-500 mt-1">Daftar lengkap riwayat distribusi gizi sekolah sebagai audit trail logistik.</p>
    </div>

    <a href="{{ route('admin.reports.export') }}"
       style="background-color: #1e293b;"
       class="text-white font-semibold py-2 px-5 rounded-lg text-sm inline-flex items-center justify-center shadow-md transition-all transform hover:scale-105 h-[42px]">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
            </path>
        </svg>
        Export PDF
    </a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-lg border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 rounded-lg border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold mb-1">Terjadi kesalahan:</p>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Tanggal</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Vendor</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Sekolah</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Porsi</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Status</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Catatan Kendala</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Feedback</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Intervensi Admin</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Update Terakhir</th>
                    <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($distributions as $d)
                    <tr class="hover:bg-gray-50 transition-colors align-top">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                            {{ $d->tanggal_pengiriman ? \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') : '-' }}
                        </td>

                        <td class="px-6 py-4 text-gray-900 font-medium whitespace-nowrap">
                            {{ $d->vendor->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-gray-900 font-medium whitespace-nowrap">
                            {{ $d->sekolah->name ?? $d->sekolah_tujuan ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-gray-700 font-semibold whitespace-nowrap">
                            {{ $d->jumlah_porsi ?? 0 }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($d->status === 'Pending')
                                <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">
                                    Pending
                                </span>
                            @elseif($d->status === 'Dikirim')
                                <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full border border-blue-100">
                                    Dikirim
                                </span>
                            @elseif($d->status === 'Diterima')
                                <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full border border-green-100">
                                    Diterima
                                </span>
                            @elseif($d->status === 'Diterima Sebagian')
                                <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-2.5 py-1 rounded-full border border-indigo-100">
                                    Diterima Sebagian
                                </span>
                            @elseif($d->status === 'Dibatalkan Admin')
                                <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">
                                    Dibatalkan Admin
                                </span>
                            @else
                                <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">
                                    {{ $d->status ?? 'Kendala' }}
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 min-w-[180px]">
                            @if(!empty($d->catatan_kendala))
                                <p class="text-xs text-red-700 bg-red-50 p-2 rounded-lg border border-red-100">
                                    {{ $d->catatan_kendala }}
                                </p>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 min-w-[220px]">
                            @forelse($d->feedbacks as $f)
                                <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-100 mb-1 last:mb-0">
                                    {{ $f->catatan }}
                                </p>
                            @empty
                                <span class="text-gray-400 text-xs">-</span>
                            @endforelse
                        </td>

                        <td class="px-6 py-4 min-w-[260px]">
                            @forelse($d->requestChanges as $change)
                                <div class="text-xs text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-100 mb-2 last:mb-0">
                                    <p>
                                        <span class="font-semibold">Porsi awal:</span>
                                        {{ $change->jumlah_porsi_awal }}
                                    </p>
                                    <p>
                                        <span class="font-semibold">Porsi baru:</span>
                                        {{ $change->jumlah_porsi_baru }}
                                    </p>
                                    <p>
                                        <span class="font-semibold">Alasan:</span>
                                        {{ $change->alasan ?? '-' }}
                                    </p>
                                </div>
                            @empty
                                <span class="text-gray-400 text-xs">-</span>
                            @endforelse
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            {{ $d->updated_at ? $d->updated_at->format('d M Y H:i') : '-' }}
                        </td>

                        <td class="px-6 py-4 min-w-[320px]">
                            @if($d->status !== 'Dibatalkan Admin')
                                <details class="mb-3">
                                    <summary class="cursor-pointer inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100 hover:bg-blue-100">
                                        Revisi
                                    </summary>

                                    <form method="POST"
                                          action="{{ route('admin.distributions.revise', $d->id) }}"
                                          class="mt-3 p-3 rounded-xl border border-blue-100 bg-blue-50/40 space-y-3">
                                        @csrf
                                        @method('PATCH')

                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal Pengiriman</label>
                                            <input type="date"
                                                   name="tanggal_pengiriman"
                                                   value="{{ $d->tanggal_pengiriman ? \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('Y-m-d') : '' }}"
                                                   class="w-full rounded-lg border-gray-300 text-xs"
                                                   required>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Sekolah Tujuan</label>
                                            <input type="text"
                                                   name="sekolah_tujuan"
                                                   value="{{ $d->sekolah_tujuan }}"
                                                   class="w-full rounded-lg border-gray-300 text-xs"
                                                   required>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Jumlah Porsi</label>
                                            <input type="number"
                                                   name="jumlah_porsi"
                                                   value="{{ $d->jumlah_porsi }}"
                                                   min="1"
                                                   class="w-full rounded-lg border-gray-300 text-xs"
                                                   required>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Status</label>
                                            <select name="status"
                                                    class="w-full rounded-lg border-gray-300 text-xs"
                                                    required>
                                                <option value="Pending" @selected($d->status === 'Pending')>Pending</option>
                                                <option value="Dikirim" @selected($d->status === 'Dikirim')>Dikirim</option>
                                                <option value="Diterima" @selected($d->status === 'Diterima')>Diterima</option>
                                                <option value="Diterima Sebagian" @selected($d->status === 'Diterima Sebagian')>Diterima Sebagian</option>
                                                <option value="Kendala" @selected($d->status === 'Kendala')>Kendala</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Alasan Intervensi</label>
                                            <textarea name="alasan_intervensi"
                                                      rows="2"
                                                      class="w-full rounded-lg border-gray-300 text-xs"
                                                      placeholder="Contoh: jumlah porsi harus disesuaikan karena kondisi darurat."
                                                      required></textarea>
                                        </div>

                                        <button type="submit"
                                                class="w-full rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                                            Simpan Revisi
                                        </button>
                                    </form>
                                </details>

                                <details>
                                    <summary class="cursor-pointer inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-50 text-red-700 border border-red-100 hover:bg-red-100">
                                        Batalkan
                                    </summary>

                                    <form method="POST"
                                          action="{{ route('admin.distributions.cancel', $d->id) }}"
                                          class="mt-3 p-3 rounded-xl border border-red-100 bg-red-50/40 space-y-3"
                                          onsubmit="return confirm('Yakin ingin membatalkan distribusi ini?')">
                                        @csrf
                                        @method('PATCH')

                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Alasan Pembatalan</label>
                                            <textarea name="alasan_intervensi"
                                                      rows="2"
                                                      class="w-full rounded-lg border-gray-300 text-xs"
                                                      placeholder="Contoh: distribusi dibatalkan karena kondisi darurat."
                                                      required></textarea>
                                        </div>

                                        <button type="submit"
                                                class="w-full rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">
                                            Konfirmasi Pembatalan
                                        </button>
                                    </form>
                                </details>
                            @else
                                <span class="text-xs text-gray-400">Distribusi sudah dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-lg font-medium text-gray-500">Belum ada data distribusi</p>
                                <p class="text-sm text-gray-400 mt-1">Riwayat distribusi akan muncul setelah vendor membuat distribusi.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $distributions->links() }}
</div>
@endsection