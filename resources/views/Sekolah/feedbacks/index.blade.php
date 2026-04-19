<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Feedback
            </h2>
            
            <a href="{{ route('sekolah.feedbacks.create') }}" style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">
                + Tambah Feedback Baru
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

            @if(session('error'))
                <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #f87171;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($feedbacks->count() > 0)
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Tanggal</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Distribusi</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Catatan</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedbacks as $feedback)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 12px; font-size: 0.875rem;">
                                        {{ $feedback->created_at->format('d-m-Y H:i') }}
                                    </td>
                                    <td style="padding: 12px; font-size: 0.875rem;">
                                        {{ $feedback->distribution->sekolah_tujuan ?? 'N/A' }} ({{ $feedback->distribution->tanggal_pengiriman ?? 'N/A' }})
                                    </td>
                                    <td style="padding: 12px; font-size: 0.875rem; max-width: 300px; word-wrap: break-word;">
                                        {{ Str::limit($feedback->catatan, 100, '...') }}
                                    </td>
                                    <td style="padding: 12px;">
                                        <form action="{{ route('sekolah.feedbacks.destroy', $feedback) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus feedback ini?');"
                                                style="background-color: #ef4444; color: white; padding: 6px 12px; border: none; border-radius: 6px; font-size: 0.75rem; font-weight: 600; cursor: pointer;"
                                            >
                                                🗑 Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="padding: 40px; text-align: center; color: #9ca3af; font-style: italic;">
                                        Belum ada feedback. Klik tombol biru di atas untuk menambah.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div style="margin-top: 2rem; text-align: center;">
                            {{ $feedbacks->links() }}
                        </div>
                    @else
                        <div style="padding: 40px; text-align: center; color: #9ca3af; font-style: italic;">
                            Belum ada feedback.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
