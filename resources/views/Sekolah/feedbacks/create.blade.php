<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Feedback Distribusi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sekolah.feedbacks.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700">Pilih Distribusi</label>
                        <select name="distribution_id" class="w-full border-gray-300 rounded-lg border px-3 py-2" required>
                            <option value="">-- Pilih Distribusi --</option>
                            @forelse ($distributions as $distribution)
                                <option value="{{ $distribution->id }}">
                                    {{ $distribution->sekolah_tujuan }} - {{ $distribution->tanggal_pengiriman }} ({{ $distribution->jumlah_porsi }} porsi)
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada distribusi tersedia</option>
                            @endforelse
                        </select>
                        @error('distribution_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Catatan / Feedback</label>
                        <textarea name="catatan" class="w-full border-gray-300 rounded-lg border px-3 py-2" rows="5" placeholder="Jelaskan discrepancy atau keluhan terkait distribusi ini..." required></textarea>
                        @error('catatan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Kirim Feedback
                    </button>
                    <a href="{{ route('sekolah.dashboard') }}" class="ml-2 text-gray-600">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
