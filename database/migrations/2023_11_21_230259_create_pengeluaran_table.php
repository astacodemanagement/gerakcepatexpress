<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            
            $table->id()->autoIncrement();
            $table->date('tanggal_pengeluaran');
            $table->string('kode_pengeluaran', 15);
            $table->string('nama_pengeluaran', 30);
            $table->string('jumlah_pengeluaran', 15);
            $table->string('keterangan', 50);
            $table->string('pic', 20);
            $table->string('bukti', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengeluaran');
    }
};
