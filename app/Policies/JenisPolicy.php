<?php
namespace App\Policies;
use App\Models\Jenis;
use App\Models\User;
class JenisPolicy {
    public function viewAny(User $user): bool { return $user->hasRole('admin', 'kasir'); }
    public function view(User $user, Jenis $jenis): bool { return $this->viewAny($user); }
    public function create(User $user): bool { return $user->hasRole('admin'); }
    public function update(User $user, Jenis $jenis): bool { return $user->hasRole('admin'); }
    public function delete(User $user, Jenis $jenis): bool { return $user->hasRole('admin'); }
}
