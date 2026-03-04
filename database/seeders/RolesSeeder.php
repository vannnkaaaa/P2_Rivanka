<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Admin', 'Agent', 'Jemaah'];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role],
                [
                    'name' => $role,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
