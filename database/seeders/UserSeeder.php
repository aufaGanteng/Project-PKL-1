<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@fitart.co.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'username' => 'manager',
            'name' => 'Manager',
            'email' => 'manager@fitart.co.id',
            'password' => Hash::make('manager123'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        User::create([
            'username' => 'user',
            'name' => 'User',
            'email' => 'user@fitart.co.id',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => true,
        ]);
    }
}
