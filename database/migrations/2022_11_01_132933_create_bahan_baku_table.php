<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanBakuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_bahan_baku');
            $table->string('nama_bahan_baku');
            $table->mediumText('spesifikasi');
            $table->unsignedBigInteger('id_satuan');
            $table->unsignedBigInteger('di_buat_oleh');
            $table->timestamps();

            $table->foreign('id_satuan')->references('id')->on('satuan');
            $table->foreign('di_buat_oleh')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bahan_baku');
    }
}
