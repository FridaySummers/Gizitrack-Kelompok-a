<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * PBI#27 – Validasi ketat dengan 2-Times Password Verification:
     * - Password dikonfirmasi dua kali (password + password_confirmation)
     * - Password wajib minimal 8 karakter, huruf besar+kecil, angka, dan simbol
     * - No HP wajib diisi dengan format angka yang valid
     * - Email harus unik dan lowercase
     *
     * PBI#28 – Role default menggunakan UserRole enum (Sekolah).
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Validasi Nama
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[\pL\s\-]+$/u', // hanya huruf, spasi, tanda hubung
            ],

            // Validasi Email
            'email' => [
                'required',
                'string',
                'lowercase',
                'email:rfc,dns',
                'max:255',
                'unique:' . User::class,
            ],

            // Validasi No HP
            'no_hp' => [
                'required',
                'string',
                'regex:/^[0-9+\-\s]+$/',
                'min:10',
                'max:20',
            ],

            // PBI#27 – 2-Times Password Verification:
            // 'confirmed' memastikan password diisi dua kali (password + password_confirmation)
            // Password::min(8)->mixedCase()->numbers()->symbols() = validasi ketat
            'password' => [
                'required',
                'confirmed', // 2-times verification
                Rules\Password::min(8)
                    ->mixedCase()   // harus ada huruf besar & kecil
                    ->numbers()     // harus ada angka
                    ->symbols(),    // harus ada simbol (!@#$ dll)
            ],
        ], [
            'name.regex'       => 'Nama hanya boleh berisi huruf dan spasi.',
            'name.min'         => 'Nama minimal 3 karakter.',
            'no_hp.required'   => 'Nomor telepon wajib diisi.',
            'no_hp.regex'      => 'Nomor telepon hanya boleh berisi angka, +, -, atau spasi.',
            'no_hp.min'        => 'Nomor telepon minimal 10 digit.',
            'no_hp.max'        => 'Nomor telepon maksimal 20 digit.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // PBI#28 – Role default Sekolah via UserRole enum
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,  // PBI#29: langsung ke tabel users
            'password' => Hash::make($request->password),
            'role'     => UserRole::Sekolah->value,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // PBI#28 – Redirect langsung ke dashboard sesuai role via enum
        return redirect(route($user->role->dashboardRoute(), absolute: false));
    }
}
