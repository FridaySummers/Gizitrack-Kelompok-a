<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use App\Models\Feedback;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribusi::with(["feedbacks", "vendor", "menu"])
            ->where("sekolah_id", auth()->id())
            ->where("status", "Dikirim")
            ->paginate(10);

        return view("sekolah.distributions.index", compact("distributions"));
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
            "action" => "required|in:terima,terima_catatan",
            "catatan" => "required_if:action,terima_catatan|string|min:3",
        ]);

        // Only allow updating if status is "Terkirim", "Di Perjalanan", or "Dikirim"
        if (
            !in_array($distribution->status, [
                "Terkirim",
                "Di Perjalanan",
                "Dikirim",
            ])
        ) {
            return redirect()
                ->back()
                ->with(
                    "error",
                    'Distribusi ini tidak dapat dikonfirmasi. Status harus "Terkirim", "Di Perjalanan", atau "Dikirim".',
                );
        }

        if ($validated["action"] === "terima") {
            // Simple receipt confirmation
            $distribution->update(["status" => "Diterima"]);
            return redirect()
                ->back()
                ->with("success", "Distribusi berhasil dikonfirmasi diterima.");
        } else {
            // Receipt with notes - partial receipt
            $distribution->update(["status" => "Diterima Sebagian"]);

            // Create feedback record
            Feedback::create([
                "distribusi_id" => $distribution->id,
                "user_id" => auth()->id(),
                "catatan" => $validated["catatan"],
            ]);

            return redirect()
                ->back()
                ->with(
                    "success",
                    "Distribusi berhasil dikonfirmasi dengan catatan.",
                );
        }
    }
}
