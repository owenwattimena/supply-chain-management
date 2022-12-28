<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanPesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaan_pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pemesanan_bahan_baku');
            $table->date('tanggal');
            $table->time('jam');
            $table->string('nomor_kendaraan')->nullable();
            $table->string('nama_pengemudi')->nullable();
            $table->timestamps();

            $table->foreign('id_pemesanan_bahan_baku')->references('id')->on('pemesanan_bahan_baku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaan_pesanan');
    }
}
