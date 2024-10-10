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
        Schema::create('profil', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nama_profil', 30);
            $table->string('alias', 15)->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->text('alamat');
            $table->string('biaya_admin', 50);
            $table->string('gambar', 50)->nullable();
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
        Schema::dropIfExists('profil');
    }
};
