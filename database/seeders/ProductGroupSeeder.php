<?php

namespace Database\Seeders;

use App\Models\ProductGroup;
use Illuminate\Database\Seeder;

class ProductGroupSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            ['code' => 'LSA', 'name' => 'LISENSI APLIKASI SICMA', 'acc_omzet' => '5033', 'cdf_piutang' => '1533'],
            ['code' => '003', 'name' => 'ACCOUNTING DAN KEUANGAN', 'acc_omzet' => '5033', 'cdf_piutang' => '1533'],
        ];

        foreach ($groups as $group) {
            ProductGroup::create($group);
        }
    }
}
