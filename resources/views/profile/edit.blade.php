@extends('layouts.sidebar')

@section('title', 'Profile Saya')

@section('content')
<div class="space-y-8 animate-fade-in">
    {{-- Profile Header Card --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="h-32 bg-emerald-600 relative">
            <div class="absolute -bottom-12 left-8">
                <div class="w-24 h-24 bg-white rounded-3xl p-1 shadow-xl">
                    <div class="w-full h-full bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                        <span class="text-3xl font-black">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-16 pb-8 px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">{{ auth()->user()->name }}</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Status Akun: {{ auth()->user()->role->label() }}</p>
                </div>
                <div class="flex items-center gap-2 text-xs font-black text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full border border-emerald-100">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    Verified Profile
                </div>
            </div>
        </div>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden transition-all duration-300">
        <div class="p-8 border-b border-gray-50 bg-gray-50/50">
            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Informasi Dasar</h3>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Detail identitas dan alamat korespondensi Anda.</p>
        </div>

        <div class="p-8">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
    </div>
@endsection
