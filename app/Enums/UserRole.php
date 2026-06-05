<?php

namespace App\Enums;

/**
 * PBI#28 – Enum Role pengguna GiziTrack.
 * Menggantikan magic string 'admin'/'vendor'/'sekolah'
 * agar akses fitur tertutup rapat dan type-safe.
 */
enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Admin      = 'admin';
    case Vendor     = 'vendor';
    case Sekolah    = 'sekolah';

    /**
     * Label tampilan untuk setiap role.
     */
    public function label(): string
    {
        return match($this) {
            UserRole::SuperAdmin => 'Super Admin',
            UserRole::Admin      => 'Admin',
            UserRole::Vendor     => 'Vendor',
            UserRole::Sekolah    => 'Sekolah',
        };
    }

    /**
     * Route dashboard tujuan setelah login.
     */
    public function dashboardRoute(): string
    {
        return match($this) {
            UserRole::SuperAdmin => 'admin.dashboard',
            UserRole::Admin      => 'admin.dashboard',
            UserRole::Vendor     => 'vendor.dashboard',
            UserRole::Sekolah    => 'sekolah.dashboard',
        };
    }
}
