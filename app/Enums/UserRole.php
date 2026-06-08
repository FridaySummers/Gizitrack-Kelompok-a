<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Admin      = 'admin';
    case Vendor     = 'vendor';
    case Sekolah    = 'sekolah';

    public function label(): string
    {
        return match($this) {
            UserRole::SuperAdmin => 'Super Admin',
            UserRole::Admin      => 'Admin',
            UserRole::Vendor     => 'Vendor',
            UserRole::Sekolah    => 'Sekolah',
        };
    }
}
