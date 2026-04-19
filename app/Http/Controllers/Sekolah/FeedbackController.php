<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Distribusi;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::where('user_id', auth()->id())
            ->with('distribution')
            ->latest()
            ->paginate(10);
        
        return view('sekolah.feedbacks.index', compact('feedbacks'));
    }

    public function create()
    {
        $distributions = Distribusi::all();
        return view('sekolah.feedbacks.create', compact('distributions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'distribution_id' => 'required|exists:distribusis,id',
            'catatan' => 'required|string|min:3',
        ]);

        Feedback::create([
            'distribution_id' => $request->distribution_id,
            'user_id' => auth()->id(),
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil dikirimkan!');
    }

    public function destroy(Feedback $feedback)
    {
        // Authorize: only the feedback owner can delete their own feedback
        if ($feedback->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus feedback ini.');
        }

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback berhasil dihapus!');
    }
}
