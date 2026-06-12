<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Distribusi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    /*
    public function index()
    {
        $feedbacks = Feedback::with('distribution')
            ->latest()
            ->paginate(10);

        return view('sekolah.feedbacks.index', compact('feedbacks'));
    }

    public function create()
    {
        $distributions = Distribusi::all();
        return view('sekolah.feedbacks.create', compact('distributions'));
    }
    */

    public function store(Request $request)
    {
        $request->validate([
            "distribusi_id" => "required|exists:distribusis,id",
            "catatan" => "required|string|min:3",
        ]);

        Feedback::create([
            "distribusi_id" => $request->distribusi_id,
            "user_id" => $this->fallbackUserId(),
            "catatan" => $request->catatan,
        ]);

        return redirect()
            ->back()
            ->with("success", "Feedback berhasil dikirimkan!");
    }

    protected function fallbackUserId(): int
    {
        return User::value("id") ??
            User::create([
                "name" => "System User",
                "email" => "system@example.com",
                "password" => Hash::make(Str::random(32)),
                "role" => "sekolah",
            ])->id;
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()
            ->back()
            ->with("success", "Feedback berhasil dihapus!");
    }
}
