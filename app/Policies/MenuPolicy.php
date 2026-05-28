<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MenuPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Menu $menu): bool
    {
        // Pengecekan PBI-32: Vendor hanya boleh mengedit menu miliknya sendiri
        return $user->id === $menu->vendor_id;
    }
}