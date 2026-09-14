<?php
namespace App\Policies;
use App\Models\Penjualan;
use App\Models\User;
class PenjualanPolicy {
    public function viewAny(User $user): bool { return $user->hasRole('admin', 'kasir'); }
    public function view(User $user, Penjualan $penjualan): bool { return $this->viewAny($user); }
    public function update(User $user, Penjualan $penjualan): bool {
        return $this->viewAny($user) && strtoupper($penjualan->status) === 'OPEN';
    }
    public function delete(User $user, Penjualan $penjualan): bool { return $this->update($user, $penjualan); }
}
