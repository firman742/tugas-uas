<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class NasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nasabah 1',
            'email' => 'nasabah1@example.com',
            'password' => Hash::make('password'),
            'role' => 'nasabah'
        ]);

        User::create([
            'name' => 'Nasabah 2',
            'email' => 'nasabah2@example.com',
            'password' => Hash::make('password'),
            'role' => 'nasabah'
        ]);
    }
}
