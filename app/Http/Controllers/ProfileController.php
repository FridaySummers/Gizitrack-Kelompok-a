<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::latest()->get();
        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('profiles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'avatar_url' => 'nullable|url',
        ]);

        Profile::create($validated);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }

    public function show(Profile $profile)
    {
        return view('profiles.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email,' . $profile->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'avatar_url' => 'nullable|url',
        ]);

        $profile->update($validated);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }
}
