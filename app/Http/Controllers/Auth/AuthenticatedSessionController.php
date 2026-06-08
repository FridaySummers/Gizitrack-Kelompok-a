<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * Redirect langsung ke dashboard sesuai role — hindari intended() yang bisa
     * mengarahkan ke URL lama yang tidak sesuai role (penyebab 403).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $role = $request->user()->role->value;

        return match($role) {
            'super_admin' => redirect()->route('admin.dashboard'),
            'admin'       => redirect()->route('admin.dashboard'),
            'vendor'      => redirect()->route('vendor.dashboard'),
            'sekolah'     => redirect()->route('sekolah.dashboard'),
            default       => redirect('/'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
