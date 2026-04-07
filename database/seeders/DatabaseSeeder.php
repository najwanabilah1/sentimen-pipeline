<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin RBTV',
            'email' => 'admin@rbtv.com',
            'password' => Hash::make('admin123456'),
            'role' => 'admin',
        ]);

        // Create Test User
        User::create([
            'name' => 'Test User',
            'email' => 'user@rbtv.com',
            'password' => Hash::make('user123456'),
            'role' => 'user',
        ]);
    }
}

