<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        $rizqia = Company::where('name', 'PT Rizqia Travel Umrah & Haji')->first();

        DB::table('bank_accounts')->insert([
            [
                'company_id' => $rizqia->id,
                'bank_name' => 'BCA',
                'account_name' => 'PT Rizqia Travel Umrah & Haji',
                'account_number' => '1234567890',
                'is_main' => true, // Bank utama
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $rizqia->id,
                'bank_name' => 'BSI',
                'account_name' => 'PT Rizqia Travel Umrah & Haji',
                'account_number' => '9876543210',
                'is_main' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $rizqia->id,
                'bank_name' => 'Mandiri',
                'account_name' => 'PT Rizqia Travel Umrah & Haji',
                'account_number' => '1122334455',
                'is_main' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $rizqia->id,
                'bank_name' => 'BRI',
                'account_name' => 'PT Rizqia Travel Umrah & Haji',
                'account_number' => '5566778899',
                'is_main' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
