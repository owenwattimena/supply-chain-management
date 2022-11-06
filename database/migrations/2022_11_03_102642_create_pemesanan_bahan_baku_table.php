<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananBahanBakuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string("nomor_pesanan");
            $table->unsignedBigInteger("id_supplier");
            $table->enum('status', ['draft', 'pending', 'proses', 'final', 'batal'])->default('draft');
            $table->unsignedBigInteger("dibuat_oleh");
            $table->unsignedBigInteger("dibatalkan_oleh")->nullable();
            $table->timestamps();

            $table->foreign('id_supplier')->references('id')->on('users');
            $table->foreign('dibuat_oleh')->references('id')->on('users');
            $table->foreign('dibatalkan_oleh')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanan_bahan_baku');
    }
}
