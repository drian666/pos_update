<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Produk extends Model
{
    use SoftDeletes, \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'user_id',
        'jenis_id',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }
}
