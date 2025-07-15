<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuSetoran extends Model
{
    protected $table = "buku_setorans";

    protected $fillable = [
        'user_id',
        'tanggal_setor',
        'jenis_sampah_id', 
        'berat',
        'total',
        'foto_bukti',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }
}
