<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $guarded = ['id'];

    /**
     * Relasi ke Item Penjualan (dipanggil oleh PenjualanSeeder)
     */
    public function itemPenjualan(): HasMany
    {
        return $this->hasMany(itemPenjualan::class, 'penjualan_id');
    }

    /**
     * Alias relasi ke Item Penjualan (jika ada bagian lain yang menggunakan $penjualan->details)
     */
    public function details(): HasMany
    {
        return $this->itemPenjualan();
    }

    /**
     * Relasi ke User / Kasir
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
