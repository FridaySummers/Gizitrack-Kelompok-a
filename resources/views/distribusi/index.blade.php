<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Distribusi Makanan
            </h2>
            
            <a href="{{ route('vendor.distribusi.create') }}" style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">
                + Input Pengiriman Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #10b981;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Tanggal</th>
                                <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Sekolah Tujuan</th>
                                <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Jumlah Porsi</th>
                                <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($distribusis as $d)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 12px;">{{ $d->tanggal_pengiriman }}</td>
                                <td style="padding: 12px;">{{ $d->sekolah_tujuan }}</td>
                                <td style="padding: 12px;">{{ $d->jumlah_porsi }}</td>
                                <td style="padding: 12px;">
                                    <span style="background-color: #fef9c3; color: #854d0e; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                        {{ $d->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="padding: 40px; text-align: center; color: #9ca3af; font-style: italic;">
                                    Belum ada data distribusi. Klik tombol biru di atas untuk menambah.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>