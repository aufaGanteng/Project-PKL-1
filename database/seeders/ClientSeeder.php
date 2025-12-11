<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'code' => 'C001',
            'status' => 'Aktif',
            'name' => 'PT Contoh Jaya',
            'address' => 'Jl. Kemerdekaan No.123',
            'city' => 'Jakarta',
            'phone' => '081234567890',
            'credit_term_days' => 30,
            'is_active' => true,
        ]);
    }
}
