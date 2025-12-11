<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            UserSeeder::class,
            BankSeeder::class,
            ChartOfAccountSeeder::class,
            InvoiceTypeSeeder::class,
            ItemSeeder::class,
            ProductGroupSeeder::class,
            SettingSeeder::class,
            ClientSeeder::class,
        ]);
    }
}
