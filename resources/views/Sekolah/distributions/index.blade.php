<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Status Distribusi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($distributions->count() > 0)
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Tanggal Pengiriman</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Jumlah Porsi</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Status</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($distributions as $d)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 12px;">{{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d-m-Y') }}</td>
                                    <td style="padding: 12px;">{{ $d->jumlah_porsi }} Porsi</td>
                                    <td style="padding: 12px;">
                                        @php
                                            $statusColors = [
                                                'Pending' => ['bg' => '#fef9c3', 'text' => '#854d0e'],
                                                'Di Perjalanan' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                                                'Terkirim' => ['bg' => '#dcfce7', 'text' => '#166534'],
                                                'Kendala' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                            ];
                                            $colors = $statusColors[$d->status] ?? ['bg' => '#e5e7eb', 'text' => '#374151'];
                                        @endphp
                                        <span style="background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $d->status }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px;">
                                        @if($d->feedbacks && $d->feedbacks->count() > 0)
                                            <span style="background-color: #f3e8ff; color: #6b21a8; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                {{ $d->feedbacks->count() }} Feedback
                                            </span>
                                        @else
                                            <span style="color: #9ca3af; font-size: 0.75rem;">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div style="margin-top: 2rem; text-align: center;">
                            {{ $distributions->links() }}
                        </div>
                    @else
                        <div style="padding: 40px; text-align: center; color: #9ca3af; font-style: italic;">
                            Belum ada data distribusi.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
