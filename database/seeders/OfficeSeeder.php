<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeSeeder extends Seeder
{
    public function run(): void
    {
        $company = \App\Models\Company::first();

        DB::table('offices')->insert([
            [
                'company_id' => $company->id,
                'name' => 'Kantor Pusat',
                'address' => 'Jl. Contoh No. 123',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '10110',
                'phone' => '08123456789',
                'is_main' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $company->id,
                'name' => 'Kantor Bandung',
                'address' => 'Jl. Ibadah No. 45',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'postal_code' => '40123',
                'phone' => '082345678901',
                'is_main' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $company->id,
                'name' => 'Kantor Surabaya',
                'address' => 'Jl. Ka\'bah No. 77',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'postal_code' => '60231',
                'phone' => '083456789012',
                'is_main' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
