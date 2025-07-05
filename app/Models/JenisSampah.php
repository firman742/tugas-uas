<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    public function setorans()
    {
        return $this->hasMany(Setoran::class, 'jenis_sampah');
    }

}
