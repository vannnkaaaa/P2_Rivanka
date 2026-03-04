<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * =====================
         * PEOPLE (ADMIN)
         * =====================
         */
        $peopleId = DB::table('people')->insertGetId([
            'fullname'   => 'Super Admin',
            'gender'     => 'L',
            'birth_date' => '2000-10-20',
            'birth_place' => 'Jakarta',
            'phone'      => '088123456789',
            'address'    => 'Kantor Pusat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        /**
         * =====================
         * ADMIN
         * =====================
         */
        $adminId = DB::table('admins')->insertGetId([
            'people_id'  => $peopleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /**
         * =====================
         * USERS (POLYMORPHIC)
         * =====================
         */
        $userId = DB::table('users')->insertGetId([
            'userable_id'       => $adminId,
            'userable_type'     => 'App\Models\Admin',
            'username'          => 'admin',
            'email'             => 'admin@pemantapan2.com',
            'password'          => Hash::make('123456'),
            'is_active'         => 1,
            'email_verified_at' => now(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        /**
         * =====================
         * ROLE USER (PIVOT)
         * =====================
         */
        $roleAdminId = DB::table('roles')
            ->where('name', 'Admin') // ✅ INI SUDAH BENAR
            ->value('id');

        DB::table('role_user')->insert([
            'user_id'    => $userId,
            'role_id'    => $roleAdminId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
