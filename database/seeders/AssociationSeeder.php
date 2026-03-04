<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssociationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('associations')->insert([
            [
                'name' => 'AMPHURI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HIMPUH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'KESTHURI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
