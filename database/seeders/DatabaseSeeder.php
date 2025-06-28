<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = collect([
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@example.com',
                'phone' => '0812345678',
                'is_active' => 1,
                'role' => 'superadmin',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'User Example 1',
                'email' => 'user1@example.com',
                'phone' => '0812345677',
                'is_active' => 1,
                'role' => 'pengguna',
                'password' => bcrypt('password'),
            ],
        ]);

        $users->each(fn ($data) => User::factory()->create($data));
    }
}
