<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'PT Rizqia Travel Umrah & Haji',
                'slug' => Str::slug('PT Rizqia Travel Umrah & Haji'),
                'ppiu_license_number' => 'U.123/2024',
                'pihk_license_number' => 'H.799/2024',
                'npwp' => '01.234.567.8-999.000',
                'main_address' => 'Jl. Contoh No. 123, Jakarta',
                'phone' => '08123456789',
                'email' => 'info@rizqiatravel.com',
                'website' => 'https://rizqiatravel.com',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
