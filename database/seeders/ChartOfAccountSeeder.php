<?php

namespace Database\Seeders;

use App\Models\ChartOfAccount;
use Illuminate\Database\Seeder;

class ChartOfAccountSeeder extends Seeder
{
    public function run()
    {
        $accounts = [
            // ASSETS
            ['code' => '1', 'name' => 'AKTIVA', 'type' => 'Asset', 'level' => 1, 'is_header' => true],
            ['code' => '11', 'name' => 'AKTIVA LANCAR', 'type' => 'Asset', 'level' => 2, 'parent_code' => '1', 'is_header' => true],
            ['code' => '1101', 'name' => 'Kas', 'type' => 'Asset', 'level' => 3, 'parent_code' => '11'],
            ['code' => '1111', 'name' => 'Deposit in Transit', 'type' => 'Asset', 'level' => 3, 'parent_code' => '11'],
            ['code' => '1201', 'name' => 'Bank BCA', 'type' => 'Asset', 'level' => 3, 'parent_code' => '11'],
            ['code' => '1202', 'name' => 'Bank Mandiri', 'type' => 'Asset', 'level' => 3, 'parent_code' => '11'],
            ['code' => '1203', 'name' => 'Bank BNI', 'type' => 'Asset', 'level' => 3, 'parent_code' => '11'],
            ['code' => '1204', 'name' => 'Bank BRI', 'type' => 'Asset', 'level' => 3, 'parent_code' => '11'],
            ['code' => '1301', 'name' => 'Piutang Usaha', 'type' => 'Asset', 'level' => 3, 'parent_code' => '11'],

            // LIABILITIES
            ['code' => '2', 'name' => 'KEWAJIBAN', 'type' => 'Liability', 'level' => 1, 'is_header' => true],
            ['code' => '21', 'name' => 'KEWAJIBAN LANCAR', 'type' => 'Liability', 'level' => 2, 'parent_code' => '2', 'is_header' => true],
            ['code' => '2101', 'name' => 'Hutang Usaha', 'type' => 'Liability', 'level' => 3, 'parent_code' => '21'],
            ['code' => '2102', 'name' => 'PPN Keluaran', 'type' => 'Liability', 'level' => 3, 'parent_code' => '21'],

            // EQUITY
            ['code' => '3', 'name' => 'MODAL', 'type' => 'Equity', 'level' => 1, 'is_header' => true],
            ['code' => '3101', 'name' => 'Modal Disetor', 'type' => 'Equity', 'level' => 2, 'parent_code' => '3'],

            // REVENUE
            ['code' => '4', 'name' => 'PENDAPATAN', 'type' => 'Revenue', 'level' => 1, 'is_header' => true],
            ['code' => '5011', 'name' => 'Pendapatan Hardware', 'type' => 'Revenue', 'level' => 2, 'parent_code' => '4'],
            ['code' => '5019', 'name' => 'Pendapatan Software', 'type' => 'Revenue', 'level' => 2, 'parent_code' => '4'],
            ['code' => '5032', 'name' => 'Pendapatan Jasa Implementasi', 'type' => 'Revenue', 'level' => 2, 'parent_code' => '4'],
            ['code' => '5033', 'name' => 'Pendapatan License', 'type' => 'Revenue', 'level' => 2, 'parent_code' => '4'],
            ['code' => '5035', 'name' => 'Pendapatan Maintenance', 'type' => 'Revenue', 'level' => 2, 'parent_code' => '4'],

            // EXPENSES
            ['code' => '5', 'name' => 'BEBAN', 'type' => 'Expense', 'level' => 1, 'is_header' => true],
            ['code' => '5101', 'name' => 'Beban Gaji', 'type' => 'Expense', 'level' => 2, 'parent_code' => '5'],
            ['code' => '5102', 'name' => 'Beban Operasional', 'type' => 'Expense', 'level' => 2, 'parent_code' => '5'],
        ];

        foreach ($accounts as $account) {
            ChartOfAccount::create($account);
        }
    }
}
