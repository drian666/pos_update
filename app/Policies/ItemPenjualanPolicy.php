<?php
namespace App\Policies;
use App\Models\ItemPenjualan;
use App\Models\User;
class ItemPenjualanPolicy {
    public function update(User $user, ItemPenjualan $item): bool {
        return $user->hasRole('admin', 'kasir') && strtoupper($item->penjualan->status) === 'OPEN';
    }
    public function delete(User $user, ItemPenjualan $item): bool { return $this->update($user, $item); }
}
