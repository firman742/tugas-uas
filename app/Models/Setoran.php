<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal_setor',
        'jenis_sampah',
        'berat',
        'harga_per_kg',
        'total',
        'foto_bukti',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenis()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah');
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah');
    }


}
