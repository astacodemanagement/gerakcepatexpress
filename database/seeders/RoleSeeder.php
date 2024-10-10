<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                [
                    'id' => '1',
                    'name' => 'superadmin',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '2',
                    'name' => 'manager',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '3',
                    'name' => 'kasir',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id' => '4',
                    'name' => 'gudang',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}
