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
        $distributions = Distribusi::with('feedbacks')
            ->paginate(10);
        
        return view('sekolah.distributions.index', compact('distributions'));
    }

    public function update(Request $request, Distribusi $distribution)
    {
        // Validate action and catatan if needed
        $validated = $request->validate([
            'action' => 'required|in:terima,terima_catatan',
            'catatan' => 'required_if:action,terima_catatan|string|min:3',
        ]);

        // Only allow updating if status is "Terkirim"
        if ($distribution->status !== 'Terkirim') {
            return redirect()->back()->with('error', 'Distribusi ini tidak dapat dikonfirmasi. Status harus "Terkirim".');
        }

        if ($validated['action'] === 'terima') {
            // Simple receipt confirmation
            $distribution->update(['status' => 'Diterima']);
            return redirect()->back()->with('success', 'Distribusi berhasil dikonfirmasi diterima.');
        } else {
            // Receipt with notes - partial receipt
            $distribution->update(['status' => 'Diterima Sebagian']);
            
            // Create feedback record
            Feedback::create([
                'distribution_id' => $distribution->id,
                'user_id' => auth()->id(),
                'catatan' => $validated['catatan'],
            ]);
            
            return redirect()->back()->with('success', 'Distribusi berhasil dikonfirmasi dengan catatan.');
        }
    }
}

