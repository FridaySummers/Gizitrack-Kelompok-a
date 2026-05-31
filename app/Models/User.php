<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * PBI#29 – no_hp disimpan langsung di tabel users (arsitektur terpusat).
     * PBI#28 – role menggunakan UserRole enum.
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'no_hp'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => UserRole::class, // PBI#28: cast ke Enum
        ];
    }

    // ── Helper methods untuk cek role (PBI#28) ──────────────────────

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin || $this->role === UserRole::SuperAdmin;
    }

    public function isVendor(): bool
    {
        return $this->role === UserRole::Vendor;
    }

    public function isSekolah(): bool
    {
        return $this->role === UserRole::Sekolah;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SuperAdmin;
    }
}
