<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cabang')->insert([
            'kode_cabang' => 'C001',
            'nama_cabang' => 'Tasikmalaya',
            'id_kota' => '1',
            'nama_kota' => 'Tasikmalaya',
            
        ]);
    }
}
