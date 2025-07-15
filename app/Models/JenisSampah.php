<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    protected $table = "jenis_sampahs";

    protected $fillable = [
        'nama',
        'harga_per_kg',
    ];

    public function buku_setorans()
    {
        return $this->hasMany(BukuSetoran::class, 'jenis_sampah_id');
    }

}
