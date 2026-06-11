<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\RequestChange;
use Illuminate\Http\Request;

class DistribusiController extends Controller
{
    public function index()
    {
        $distribusis = Distribusi::with(['requestChanges'])
            ->latest()
            ->paginate(10);

        return view("admin.distribusi.index", compact("distribusis"));
    }

    public function create()
    {
        return view("distribusi.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "sekolah_tujuan" => "required|string|max:255",
            "jumlah_porsi" => "required|integer|min:1",
            "tanggal_pengiriman" => "required|date",
        ]);

        Distribusi::create([
            "sekolah_tujuan" => $request->sekolah_tujuan,
            "jumlah_porsi" => $request->jumlah_porsi,
            "tanggal_pengiriman" => $request->tanggal_pengiriman,
            "status" => "Dikirim",
        ]);

        return redirect()
            ->route("vendor.distribusi.index")
            ->with("success", "Data distribusi berhasil ditambahkan!");
    }

    public function edit($id)
    {
        $distribusi = Distribusi::findOrFail($id);
        return view("distribusi.edit", compact("distribusi"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "tanggal_pengiriman" => "required|date",
            "sekolah_tujuan" => "required|string|max:255",
            "jumlah_porsi" => "required|integer|min:1",
            "status" => "required|string",
            "alasan_perubahan" => "nullable|string|max:500",
        ]);

        $distribusi = Distribusi::findOrFail($id);

        // PBI-35: Catat request change jika jumlah porsi berubah
        if ($distribusi->jumlah_porsi != $request->jumlah_porsi) {
            RequestChange::create([
                "distribusi_id" => $distribusi->id,
                "jumlah_porsi_awal" => $distribusi->jumlah_porsi,
                "jumlah_porsi_baru" => $request->jumlah_porsi,
                "alasan" => $request->alasan_perubahan ?? "Tidak ada alasan",
            ]);
        }

        $distribusi->update([
            "tanggal_pengiriman" => $request->tanggal_pengiriman,
            "sekolah_tujuan" => $request->sekolah_tujuan,
            "jumlah_porsi" => $request->jumlah_porsi,
            "status" => $request->status,
        ]);

        return redirect()
            ->route("vendor.distribusi.index")
            ->with("success", "Data berhasil diupdate");
    }

    public function destroy($id)
    {
        $distribusi = Distribusi::findOrFail($id);
        $distribusi->delete();

        return redirect()
            ->route("vendor.distribusi.index")
            ->with("success", "Data berhasil dihapus");
    }
    public function riwayat(Request $request)
    {
        $tanggal = $request->query("tanggal", now()->toDateString());

        $distribusis = Distribusi::with("requestChanges")
            ->whereDate("tanggal_pengiriman", $tanggal)
            ->orderBy("updated_at", "desc")
            ->get();

        $summary = [
            "total_pengiriman" => $distribusis->count(),
            "total_porsi" => $distribusis->sum("jumlah_porsi"),
            "diterima" => $distribusis
                ->whereIn("status", ["Diterima", "Diterima Sebagian"])
                ->count(),
            "dikirim" => $distribusis->where("status", "Dikirim")->count(),
            "kendala" => $distribusis
                ->whereIn("status", ["Kendala", "Komplain"])
                ->count(),
            "pending" => $distribusis->where("status", "Pending")->count(),
        ];

        return view(
            "distribusi.riwayat",
            compact("distribusis", "tanggal", "summary"),
        );
    }

    public function apiIndex()
    {
        $distribusis = Distribusi::select(
            "id",
            "sekolah_tujuan",
            "jumlah_porsi",
            "tanggal_pengiriman",
            "status",
            "latitude",
            "longitude",
            "last_updated",
        )->get();
        return response()->json($distribusis);
    }
}
