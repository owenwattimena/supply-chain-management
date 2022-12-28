<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_supplier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dibuat_oleh');
            $table->enum('tipe', ['keluar', 'masuk']);
            $table->enum('status', ['pending', 'final']);
            $table->timestamps();
            $table->timestamp('final_at')->nullable();

            $table->foreign('dibuat_oleh')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_supplier');
    }
}
