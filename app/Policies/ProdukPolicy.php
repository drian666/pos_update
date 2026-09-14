<?php

namespace App\Policies;


// BENAR
use App\Models\Produk;
use App\Models\User;

class ProdukPolicy
{
   public function viewAny(User $user): bool
{
    return $user->hasRole('admin', 'kasir');
}

/**
 * Determine whether the user can view the model.
 */
public function view(User $user, Produk $produk): bool
{
    return $user->hasRole('admin', 'kasir');
}

/**
 * Determine whether the user can create models.
 */
public function create(User $user): bool
{
    return $user->hasRole('admin');
}

/**
 * Determine whether the user can update the model.
 */
public function update(User $user, Produk $produk): bool
{
    return $user->hasRole('admin');
}

/**
 * Determine whether the user can delete the model.
 */
public function delete(User $user, Produk $produk): bool
{
    return $user->hasRole('admin');
}
}
