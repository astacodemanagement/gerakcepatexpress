<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengeluaran')->insert([
            'tanggal_pengeluaran' => '2023-01-01',
            'kode_pengeluaran' => 'EX0001',
            'nama_pengeluaran' => 'Bayar Gaji',
            'jumlah_pengeluaran' => '2000000',
            'keterangan' => 'Tes Keterangan',
            'pic' => 'Rafi Heryadi',
            'bukti' => 'bukti.png',
            
        ]);
    }
}
