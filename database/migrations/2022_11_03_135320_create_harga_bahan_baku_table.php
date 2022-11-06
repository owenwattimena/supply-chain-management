<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaBahanBakuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bahan_baku');
            $table->bigInteger('harga_jual');
            $table->boolean('status')->default(true);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_bahan_baku')->references('id')->on('bahan_baku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('harga_bahan_baku');
    }
}
