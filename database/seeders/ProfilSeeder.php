<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('profil')->insert([
            'nama_profil' => 'Gerak Cepat Express',
            'alias' => 'GCE',
            'no_telp' => '085320555394',
            'email' => 'gce@gmail.com',
            'alamat' => 'Jl. Tajur Indah',
            'biaya_admin' => '100000',
        ]);
    }
}
