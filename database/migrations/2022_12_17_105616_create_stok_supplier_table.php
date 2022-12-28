<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_supplier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bahan_baku')->unique();
            $table->bigInteger('stok');
            $table->timestamps();

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
        Schema::dropIfExists('stok_supplier');
    }
}
