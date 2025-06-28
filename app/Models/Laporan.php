<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    /** @use HasFactory<\Database\Factories\LaporanFactory> */
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'tanggal', 'jenis_barang', 'jumlah_barang',
        'user_id', 'status', 'verifikasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
