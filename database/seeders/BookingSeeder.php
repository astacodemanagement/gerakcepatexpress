<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking')->insert([
            'kode_resi' => 'GCE0001',
            'nama_barang' => 'Elektronik',
            'koli' => '1',
            'berat' => '5',
            
        ]);
    }
}
