<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use Illuminate\Http\Request;

class DistribusiController extends Controller
{
    public function index()
    {
        $distribusis = Distribusi::paginate(10);
        return view('distribusi.index', compact('distribusis'));
    }

    public function create()
    {
        return view('distribusi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sekolah_tujuan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'tanggal_pengiriman' => 'required|date',
        ]);

        Distribusi::create([
            'sekolah_tujuan' => $request->sekolah_tujuan,
            'jumlah_porsi' => $request->jumlah_porsi,
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'status' => 'Dikirim',
        ]);

        return redirect()->route('vendor.distribusi.index')
            ->with('success', 'Data distribusi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $distribusi = Distribusi::findOrFail($id);
        return view('distribusi.edit', compact('distribusi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'sekolah_tujuan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $distribusi = Distribusi::findOrFail($id);

        $distribusi->update([
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'sekolah_tujuan' => $request->sekolah_tujuan,
            'jumlah_porsi' => $request->jumlah_porsi,
            'status' => "Dikirim",
        ]);

        return redirect()->route('vendor.distribusi.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $distribusi = Distribusi::findOrFail($id);
        $distribusi->delete();

        return redirect()->route('vendor.distribusi.index')
            ->with('success', 'Data berhasil dihapus');
    }
    public function apiIndex()
    {
        $distribusis = Distribusi::select('id', 'sekolah_tujuan', 'jumlah_porsi', 'tanggal_pengiriman', 'status', 'latitude', 'longitude', 'last_updated')->get();
        return response()->json($distribusis);
    }
}