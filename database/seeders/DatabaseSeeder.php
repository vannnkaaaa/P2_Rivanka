<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            AssociationSeeder::class,
            CompanySeeder::class,
            OfficeSeeder::class,
            BankAccountSeeder::class,
        ]);
    }
}
