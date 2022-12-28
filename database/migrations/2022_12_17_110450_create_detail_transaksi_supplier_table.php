<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksiSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi_supplier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_transaksi_supplier');
            $table->unsignedBigInteger('id_bahan_baku');
            $table->bigInteger('jumlah');

            $table->foreign('id_transaksi_supplier')->references('id')->on('transaksi_supplier');
            $table->foreign('id_bahan_baku')->references('id')->on('bahan_baku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi_supplier');
    }
}
