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
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sekolah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Porsi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Feedback</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($distributions as $d)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $d->sekolah_tujuan }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $d->jumlah_porsi }}</td>
                <td class="px-6 py-4">
                    @if($d->status === 'Pending')
                    <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full">Pending</span>
                    @elseif(in_array($d->status, ['Di Perjalanan','Terkirim']))
                    <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $d->status }}</span>
                    @elseif($d->status === 'Diterima')
                    <span class="bg-emerald-50 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-full">Diterima</span>
                    @elseif($d->status === 'Diterima Sebagian')
                    <span class="bg-orange-50 text-orange-700 text-xs font-medium px-2.5 py-1 rounded-full">Diterima Sebagian</span>
                    @else
                    <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">Kendala</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($d->feedbacks && $d->feedbacks->count() > 0)
                    <span class="bg-purple-50 text-purple-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $d->feedbacks->count() }} Feedback</span>
                    @else
                    <span class="text-gray-400 text-sm">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $distributions->links() }}
@endsection
