@extends('layouts.sidebar')

@section('title', 'Profile Saya')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Profile Information</h2>
        <p class="text-gray-500 mt-1">Perbarui data diri dan kontak Anda di sini.</p>
    </div>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>
@endsection
