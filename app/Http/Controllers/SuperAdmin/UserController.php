<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * [PBI] Super Admin: tampilkan SEMUA akun (semua role),
     * dengan akun sendiri di-pin paling atas.
     */
    public function index()
    {
        $authId = auth()->id();

        $users = User::orderByRaw("CASE WHEN id = ? THEN 0 ELSE 1 END", [$authId])
            ->latest()
            ->paginate(10);

        return view('super_admin.users.index', compact('users'));
    }

    /**
     * [PBI] Super Admin: form tambah akun.
     * Super Admin TIDAK bisa membuat akun super_admin baru (hanya 1 boleh ada).
     */
    public function create()
    {
        // Exclude super_admin dari pilihan role
        $roles = array_filter(UserRole::cases(), fn($r) => $r !== UserRole::SuperAdmin);

        return view('super_admin.users.create', compact('roles'));
    }

    /**
     * [PBI] Super Admin: simpan akun baru.
     * Role super_admin TIDAK boleh dipilih.
     */
    public function store(Request $request)
    {
        // Exclude super_admin dari role yang diizinkan
        $validRoles = array_column(
            array_filter(UserRole::cases(), fn($r) => $r !== UserRole::SuperAdmin),
            'value'
        );

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:' . implode(',', $validRoles),
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('super_admin.users.index')
            ->with('success', 'Akun berhasil didaftarkan!');
    }

    /**
     * [PBI] Super Admin: form edit akun.
     * Super Admin TIDAK bisa edit akunnya sendiri.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        if ((int) $id === auth()->id()) {
            return redirect()->route('super_admin.users.index')
                ->with('error', 'Anda tidak dapat mengedit akun Anda sendiri.');
        }

        // Exclude super_admin dari pilihan role saat edit
        $roles = array_filter(UserRole::cases(), fn($r) => $r !== UserRole::SuperAdmin);

        return view('super_admin.users.edit', compact('user', 'roles'));
    }

    /**
     * [PBI] Super Admin: update akun.
     * Super Admin TIDAK bisa update akunnya sendiri.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ((int) $id === auth()->id()) {
            return redirect()->route('super_admin.users.index')
                ->with('error', 'Anda tidak dapat mengedit akun Anda sendiri.');
        }

        // Exclude super_admin dari role yang diizinkan
        $validRoles = array_column(
            array_filter(UserRole::cases(), fn($r) => $r !== UserRole::SuperAdmin),
            'value'
        );

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:' . implode(',', $validRoles),
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('super_admin.users.index')
            ->with('success', 'Data akun berhasil diperbarui!');
    }

    /**
     * [PBI] Super Admin: hapus akun.
     * Super Admin TIDAK bisa hapus akunnya sendiri.
     */
    public function destroy(string $id)
    {
        if ((int) $id === auth()->id()) {
            return redirect()->route('super_admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('super_admin.users.index')
            ->with('success', 'Akun berhasil dihapus!');
    }
}
