<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisSampah;

class JenisSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Botol Plastik', 'harga_per_kg' => 3000],
            ['nama' => 'Kertas', 'harga_per_kg' => 1500],
            ['nama' => 'Kaleng', 'harga_per_kg' => 4000],
            ['nama' => 'Kaca', 'harga_per_kg' => 2000],
            ['nama' => 'Elektronik Rusak', 'harga_per_kg' => 5000],
        ];

        foreach ($data as $item) {
            JenisSampah::create($item);
        }
    }
}
