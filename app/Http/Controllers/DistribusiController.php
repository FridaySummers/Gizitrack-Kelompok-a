<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use Illuminate\Http\Request;

class DistribusiController extends Controller
{
    
    public function index()
    {
        $distribusis = Distribusi::all();
        return view('distribusi.index', compact('distribusis'));
    }

    
    public function create()
    {
        return view('distribusi.create');
    }

    
    public function store(Request $request)
    {
        // 1. Validasi: Pastikan data diisi dengan benar
        $request->validate([
            'sekolah_tujuan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'tanggal_pengiriman' => 'required|date',
        ]);

        // 2. Simpan ke database
        Distribusi::create([
            'sekolah_tujuan' => $request->sekolah_tujuan,
            'jumlah_porsi' => $request->jumlah_porsi,
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'status' => 'Pending', // Default status awal
        ]);

        // 3. Balik ke halaman utama dengan pesan sukses
        return redirect()->route('vendor.distribusi.index')->with('success', 'Data distribusi berhasil ditambahkan!');
    }
}