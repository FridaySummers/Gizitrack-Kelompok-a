<<<<<<< HEAD
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Status Semua Distribusi
            </h2>
            <a href="{{ route('admin.reports.export') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded text-sm">
                Export
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($distributions->count() > 0)
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Sekolah Tujuan</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">TANGGAL</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Jumlah Porsi</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Status</th>
                                    <th style="text-align: left; padding: 12px; font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($distributions as $d)
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 12px;">{{ $d->sekolah_tujuan }}</td>
                                    <td style="padding: 12px;">{{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d-m-Y') }}</td>
                                    <td style="padding: 12px;">{{ $d->jumlah_porsi }} Porsi</td>
                                    <td style="padding: 12px;">
                                        @php
                                            $statusColors = [
                                                'Pending' => ['bg' => '#fef9c3', 'text' => '#854d0e'],
                                                'Di Perjalanan' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                                                'Terkirim' => ['bg' => '#dcfce7', 'text' => '#166534'],
                                                'Diterima' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                                                'Diterima Sebagian' => ['bg' => '#fce7f3', 'text' => '#831843'],
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
=======
@extends('layouts.sidebar')

@section('title', 'All Distributions')
>>>>>>> 53f90b7ef7e2319fd437e8008fe77906570129ee

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                <th scope="col" class="px-6 py-4 font-semibold">Sekolah</th>
                <th scope="col" class="px-6 py-4 font-semibold">Porsi</th>
                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                <th scope="col" class="px-6 py-4 font-semibold">Feedback</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($distributions as $d)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">{{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}</td>
                <td class="px-6 py-4 text-gray-900 font-medium">{{ $d->sekolah_tujuan }}</td>
                <td class="px-6 py-4 text-gray-700 font-semibold">{{ $d->jumlah_porsi }}</td>
                <td class="px-6 py-4">
                    @if($d->status === 'Pending')
                    <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">Pending</span>
                    @elseif($d->status === 'Dikirim')
                    <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">Dikirim</span>
                    @elseif($d->status === 'Diterima')
                    <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full border border-green-100">Diterima</span>
                    @elseif($d->status === 'Diterima Sebagian')
                    <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full border border-blue-100">Diterima Sebagian</span>
                    @else
                    <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">Kendala</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @forelse($d->feedbacks as $f)
                    <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-100 mb-1 last:mb-0">{{ $f->catatan }}</p>
                    @empty
                    <span class="text-gray-400 text-xs">-</span>
                    @endforelse
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-lg font-medium text-gray-500">Belum ada data distribusi</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $distributions->links() }}
@endsection
