<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * Mengambil alih sesi akun lain.
     * Hanya boleh dilakukan oleh Super Admin.
     */
    public function take(User $user)
    {
        // Keamanan: Pastikan hanya Super Admin yang bisa memicu
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Aksi ini hanya diizinkan untuk Super Admin.');
        }

        // Keamanan: Jangan impersonate diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat masuk sebagai diri sendiri.');
        }

        // Simpan ID asli Super Admin ke session
        session(['impersonator_id' => auth()->id()]);

        // Login sebagai user target
        Auth::login($user);

        // Redirect ke dashboard (akan diarahkan otomatis sesuai role target)
        return redirect()->route('dashboard')->with('success', "Mode Impersonasi Aktif: Anda sekarang masuk sebagai {$user->name}");
    }

    /**
     * Kembali ke sesi Super Admin asli.
     */
    public function leave()
    {
        if (!session()->has('impersonator_id')) {
            return redirect()->route('dashboard');
        }

        $adminId = session('impersonator_id');
        $admin = User::findOrFail($adminId);

        // Login kembali ke Super Admin
        Auth::login($admin);

        // Hapus jejak session
        session()->forget('impersonator_id');

        return redirect()->route('super_admin.users.index')
            ->with('success', 'Berhasil kembali ke sesi Super Admin.');
    }
}
