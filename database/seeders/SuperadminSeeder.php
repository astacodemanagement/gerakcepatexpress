<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
                    [
                        'id' => 1,
                        'name' => 'Superadmin',
                        'email' => 'su@gce.com',
                        'password' => Hash::make('12345678'),
                        'email_verified_at' => now()
                    ]
                );

        $user->assignRole('superadmin');
    }
}