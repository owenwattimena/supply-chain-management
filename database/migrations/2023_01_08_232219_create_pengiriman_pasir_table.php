<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimanPasirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengiriman_pasir', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kendaraan');
            $table->string('nama_pengemudi');
            $table->unsignedBigInteger('id_bahan_baku');
            $table->double('jumlah');
            $table->enum('status', ['pengiriman', 'diterima', 'ditolak']);
            $table->string('foto_penerimaan')->nullable();
            $table->timestamp('tanggal_penerimaan')->nullable();
            $table->unsignedBigInteger('diterima_oleh')->nullable();
            $table->unsignedBigInteger('ditolak_oleh')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();

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
        Schema::dropIfExists('pengiriman_pasir');
    }
}
