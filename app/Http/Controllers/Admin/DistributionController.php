<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use App\Models\RequestChange;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribusi::with(['feedbacks', 'requestChanges'])
            ->latest()
            ->paginate(10);

        return view('admin.distributions.index', compact('distributions'));
    }

    public function revise(Request $request, Distribusi $distribution)
    {
        $validated = $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'sekolah_tujuan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
            'alasan_intervensi' => 'required|string|max:500',
        ]);

        RequestChange::create([
            'distribusi_id' => $distribution->id,
            'jumlah_porsi_awal' => $distribution->jumlah_porsi,
            'jumlah_porsi_baru' => $validated['jumlah_porsi'],
            'alasan' => '[Revisi Admin] ' . $validated['alasan_intervensi'],
        ]);

        $distribution->update([
            'tanggal_pengiriman' => $validated['tanggal_pengiriman'],
            'sekolah_tujuan' => $validated['sekolah_tujuan'],
            'jumlah_porsi' => $validated['jumlah_porsi'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.distributions.index')
            ->with('success', 'Distribusi berhasil direvisi oleh admin.');
    }

    public function cancel(Request $request, Distribusi $distribution)
    {
        $validated = $request->validate([
            'alasan_intervensi' => 'required|string|max:500',
        ]);

        RequestChange::create([
            'distribusi_id' => $distribution->id,
            'jumlah_porsi_awal' => $distribution->jumlah_porsi,
            'jumlah_porsi_baru' => 0,
            'alasan' => '[Pembatalan Admin] ' . $validated['alasan_intervensi'],
        ]);

        $distribution->update([
            'jumlah_porsi' => 0,
            'status' => 'Kendala',
        ]);

        return redirect()
            ->route('admin.distributions.index')
            ->with('success', 'Distribusi berhasil dibatalkan oleh admin.');
    }
}