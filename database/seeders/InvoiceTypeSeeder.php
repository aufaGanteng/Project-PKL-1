<?php

namespace Database\Seeders;

use App\Models\InvoiceType;
use Illuminate\Database\Seeder;

class InvoiceTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['code' => '501', 'name' => 'PENJUALAN HARDWARE', 'is_license' => false, 'auto_create_number' => true],
            ['code' => '502', 'name' => 'PENJUALAN SOFTWARE', 'is_license' => false, 'auto_create_number' => true],
            ['code' => '503', 'name' => 'PENDAPATAN JASA', 'is_license' => false, 'auto_create_number' => true],
            ['code' => '504', 'name' => 'PENDAPATAN LICENSE', 'is_license' => true, 'auto_create_number' => true],
            ['code' => '505', 'name' => 'PERGOLEHAN LAINNYA', 'is_license' => false, 'auto_create_number' => true],
        ];

        foreach ($types as $type) {
            InvoiceType::create($type);
        }
    }
}
