<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - GiziTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center p-8 bg-white rounded-lg shadow-lg max-w-md">
        <h1 class="text-6xl font-bold text-red-500 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Akses Ditolak!</h2>
        <p class="text-gray-600 mb-6">Maaf, Anda tidak memiliki izin untuk mengakses, mengubah, atau menghapus menu ini. Ini bukan menu milik toko Anda.</p>
        <a href="{{ route('vendor.menu.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
            Kembali ke Katalog Menu
        </a>
    </div>
</body>
</html>