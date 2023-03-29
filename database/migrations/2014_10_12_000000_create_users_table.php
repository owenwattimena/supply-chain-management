<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            // $table->string('email');
            $table->string('password');
            $table->enum('role', ['developer', 'pt_lamco', 'admin', 'stockpile', 'stockpile_pasir', 'produksi', 'supplier', 'supplier_pasir', 'manager']);
            $table->string('nik')->nullable();
            $table->string('no_plat')->nullable();
            $table->string('stnk')->nullable();
            $table->mediumText('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('web')->nullable();

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
        Schema::dropIfExists('users');
    }
}
