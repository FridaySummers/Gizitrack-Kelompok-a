<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - GiziTrack</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css/figtree.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Figtree', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-white rounded-[3rem] border border-gray-100 shadow-2xl overflow-hidden text-center p-12 transition-all duration-500 hover:shadow-emerald-100/50">
        <div class="w-24 h-24 bg-rose-50 rounded-3xl flex items-center justify-center mx-auto mb-8 text-rose-600 animate-bounce">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>

        <h1 class="text-7xl font-black text-gray-900 tracking-tighter mb-4">403</h1>
        <h2 class="text-xl font-black text-gray-800 uppercase tracking-widest mb-4">Otoritas Ditolak</h2>
        <p class="text-gray-500 font-medium leading-relaxed mb-10">
            Identitas Anda tidak memiliki izin untuk melakukan tindakan atau mengakses resource ini. Sistem GiziTrack menjaga integritas data secara ketat.
        </p>

        <a href="{{ route('dashboard') }}"
           class="inline-block w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
