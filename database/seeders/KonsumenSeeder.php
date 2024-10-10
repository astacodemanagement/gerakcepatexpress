<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonsumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('konsumen')->insert([
            'nama_konsumen' => 'Rahadian',
            'no_telp' => '085320555394',
            'email' => 'gce@gmail.com',
            'alamat' => 'Jl. Tajur Indah',
        ]);
    }
}
