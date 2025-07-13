<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    /** @use HasFactory<\Database\Factories\SetoranFactory> */
    use HasFactory;

    protected $table = 'ranking_setorans';

    protected $fillable = [
        'nama', 'jumlah'
    ];
}
