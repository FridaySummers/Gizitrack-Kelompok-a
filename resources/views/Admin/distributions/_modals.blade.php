<!-- Revise Modal -->
<div id="reviseModal-{{ $d->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
    <div class="relative w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-8 border-b border-gray-50 bg-gray-50/50">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">
                            Revisi Distribusi
                        </h3>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">ID Transaksi: #{{ $d->id }}</p>
                    </div>
                </div>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors" data-modal-hide="reviseModal-{{ $d->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('admin.distributions.revise', $d->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PATCH')

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tanggal Pengiriman</label>
                    <input type="date" name="tanggal_pengiriman" value="{{ $d->tanggal_pengiriman ? \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('Y-m-d') : '' }}"
                           class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Sekolah Tujuan</label>
                    <input type="text" name="sekolah_tujuan" value="{{ $d->sekolah_tujuan }}"
                           class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jumlah Porsi</label>
                        <input type="number" name="jumlah_porsi" value="{{ $d->jumlah_porsi }}" min="1"
                               class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Status</label>
                        <select name="status" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold" required>
                            <option value="Pending" @selected($d->status === 'Pending')>Pending</option>
                            <option value="Dikirim" @selected($d->status === 'Dikirim')>Dikirim</option>
                            <option value="Diterima" @selected($d->status === 'Diterima')>Diterima</option>
                            <option value="Diterima Sebagian" @selected($d->status === 'Diterima Sebagian')>Diterima Sebagian</option>
                            <option value="Kendala" @selected($d->status === 'Kendala')>Kendala</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Alasan Intervensi</label>
                    <textarea name="alasan_intervensi" rows="3"
                              class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold placeholder:text-gray-300"
                              placeholder="Alasan perubahan data..." required></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal-{{ $d->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
    <div class="relative w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-8 border-b border-gray-50 bg-rose-50/50">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-rose-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-rose-900 uppercase tracking-tight">
                            Batalkan Distribusi
                        </h3>
                        <p class="text-[10px] font-bold text-rose-400 uppercase tracking-widest mt-0.5">Tindakan Irreversibel</p>
                    </div>
                </div>
                <button type="button" class="text-rose-400 bg-transparent hover:bg-rose-100 hover:text-rose-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors" data-modal-hide="cancelModal-{{ $d->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('admin.distributions.cancel', $d->id) }}" method="POST" class="p-8 space-y-6" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengiriman ini?')">
                @csrf
                @method('PATCH')

                <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100 flex gap-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-[11px] font-bold text-rose-800 leading-relaxed uppercase tracking-tight">Tindakan ini akan membatalkan pengiriman sepenuhnya dan mengubah status menjadi 'Kendala'.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Alasan Pembatalan</label>
                    <textarea name="alasan_intervensi" rows="3"
                              class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none font-bold placeholder:text-gray-300"
                              placeholder="Wajib diisi..." required></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-rose-600 hover:bg-rose-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-rose-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        Konfirmasi Pembatalan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
