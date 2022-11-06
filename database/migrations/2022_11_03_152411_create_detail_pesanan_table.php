<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_bahan_baku');
            $table->bigInteger('kuantitas');
            $table->unsignedBigInteger('id_harga');

            $table->foreign('id_pesanan')->references('id')->on('pemesanan_bahan_baku');
            $table->foreign('id_bahan_baku')->references('id')->on('bahan_baku');
            $table->foreign('id_harga')->references('id')->on('harga_bahan_baku');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pesanan');
    }
}
