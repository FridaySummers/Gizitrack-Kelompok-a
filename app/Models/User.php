<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "name",
        "email",
        "password",
        "role",
        "no_hp",
        "alamat",
    ];

    protected $hidden = ["password", "remember_token"];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "role" => UserRole::class,
        ];
    }

    // Helper methods untuk cek role ──────────────────────
    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SuperAdmin;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isVendor(): bool
    {
        return $this->role === UserRole::Vendor;
    }

    public function isSekolah(): bool
    {
        return $this->role === UserRole::Sekolah;
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, "vendor_id");
    }

    public function distribusiAsVendor()
    {
        return $this->hasMany(Distribusi::class, "vendor_id");
    }

    public function distribusiAsSekolah()
    {
        return $this->hasMany(Distribusi::class, "sekolah_id");
    }
}
