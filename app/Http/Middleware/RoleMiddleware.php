<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PBI#28 – Middleware validasi role menggunakan UserRole enum.
 * Akses fitur tertutup rapat berdasarkan role yang di-cast sebagai enum.
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Akses ditolak.');
        }

        // role sudah di-cast ke UserRole enum, ambil .value untuk bandingkan
        $userRoleValue = $user->role instanceof UserRole
            ? $user->role->value
            : (string) $user->role;

        if (!in_array($userRoleValue, $roles)) {
            abort(403, 'Akses ditolak. Role Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}