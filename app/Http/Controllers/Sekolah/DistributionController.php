<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use App\Models\Feedback;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query("tab");
        $query = Distribusi::with(["feedbacks", "vendor", "menu"])->where(
            "sekolah_id",
            auth()->id(),
        );

        if ($tab === "history") {
            // Fetch all history (all statuses)
            $query->latest();
        } else {
            // Default: only active shipments
            $query->where("status", "Dikirim");
        }

        $distributions = $query->paginate(10);

        return view(
            "sekolah.distributions.index",
            compact("distributions", "tab"),
        );
    }

    public function update(Request $request, Distribusi $distribution)
    {
        // PBI-37: Quick receipt confirmation logic
        // Authorize: only the targeted school can confirm receipt
        if ($distribution->sekolah_id !== auth()->id()) {
            abort(
                403,
                "Anda tidak memiliki izin untuk mengonfirmasi distribusi ini.",
            );
        }

        // Validate action and catatan if needed
        $validated = $request->validate([
            "action" => "required|in:terima,terima_catatan,resolve_komplain",
            "catatan" => "required_if:action,terima_catatan|string|min:3",
        ]);

        // Only allow updating if status is "Dikirim" (for confirmation) or "Komplain" (for resolution)
        if (!in_array($distribution->status, ["Dikirim", "Komplain"])) {
            return redirect()
                ->back()
                ->with(
                    "error",
                    "Distribusi ini tidak dapat diproses. Status tidak sesuai.",
                );
        }

        if ($validated["action"] === "terima") {
            // Simple receipt confirmation
            $distribution->update(["status" => "Diterima"]);

            return redirect()
                ->back()
                ->with("success", "Distribusi berhasil dikonfirmasi diterima.");
        }

        if ($validated["action"] === "resolve_komplain") {
            // PBI-38: Resolve existing complaint
            $distribution->update(["status" => "Diterima"]);

            return redirect()
                ->back()
                ->with("success", "Komplain berhasil ditandai selesai.");
        }

        if ($validated["action"] === "terima_catatan") {
            // PBI-38: Confirmation with notes (Complaint)
            \DB::transaction(function () use ($distribution, $validated) {
                // Update status to Komplain
                $distribution->update(["status" => "Komplain"]);

                // Create feedback record
                Feedback::create([
                    "distribusi_id" => $distribution->id,
                    "user_id" => auth()->id(),
                    "catatan" => $validated["catatan"],
                ]);
            });

            return redirect()
                ->back()
                ->with(
                    "success",
                    "Komplain berhasil dikirim dan sedang dalam penanganan.",
                );
        }
    }
}
