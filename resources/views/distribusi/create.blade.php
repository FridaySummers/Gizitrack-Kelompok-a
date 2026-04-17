<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Data Distribusi Makanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('vendor.distribusi.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700">Sekolah Tujuan</label>
                        <input type="text" name="sekolah_tujuan" class="w-full border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Jumlah Porsi</label>
                        <input type="number" name="jumlah_porsi" class="w-full border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tanggal Pengiriman</label>
                        <input type="date" name="tanggal_pengiriman" class="w-full border-gray-300 rounded-lg" required>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Simpan Data
                    </button>
                    <a href="{{ route('vendor.distribusi.index') }}" class="ml-2 text-gray-600">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>