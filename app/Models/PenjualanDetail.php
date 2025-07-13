<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $fillable = ['penjualan_id', 'jenis_sampah', 'jumlah', 'total_penjualan'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
