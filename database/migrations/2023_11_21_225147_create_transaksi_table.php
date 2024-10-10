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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->date('tanggal_booking');
            $table->date('tanggal_kirim')->nullable();
            $table->date('tanggal_terima')->nullable();
            $table->date('tanggal_bawa')->nullable();
            $table->string('kode_resi', 15);
            $table->string('nama_barang', 50);
            $table->string('koli', 30);
            $table->decimal('berat', 20,3);
            $table->bigInteger('konsumen_id')->nullable();
            $table->string('nama_konsumen', 30)->nullable();
            $table->bigInteger('branch_id_asal')->nullable();
            $table->bigInteger('branch_id_tujuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->decimal('harga', 20,3)->nullable();
            $table->decimal('harga_kirim', 20,3)->nullable();
            $table->decimal('sub_charge', 20,3)->nullable();
            $table->decimal('biaya_admin', 20,3)->nullable();
            $table->decimal('total', 20,3)->nullable();
            $table->string('jenis_pembayaran', 30)->nullable();
            $table->string('metode_pembayaran', 30)->nullable();
            $table->decimal('jumlah_bayar', 20,3)->nullable();
            $table->string('bukti_bayar', 30)->nullable();
            $table->string('status_bayar', 30)->nullable();
            $table->string('status_bawa', 30)->nullable();
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
        Schema::dropIfExists('transaksi');
    }
};
