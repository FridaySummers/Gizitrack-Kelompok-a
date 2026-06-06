<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;

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

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Menu $menu): bool
    {
        // Pengecekan PBI-32: Vendor hanya boleh menghapus menu miliknya sendiri
        return $user->id === $menu->vendor_id;
    }
}