<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    /** @use HasFactory<\Database\Factories\SetoranFactory> */
    use HasFactory;

    protected $table = 'setorans';

    protected $fillable = [
        'nama', 'jumlah'
    ];
}
