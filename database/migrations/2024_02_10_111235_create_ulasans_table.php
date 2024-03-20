<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlasansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_perbaikan');
            $table->integer('id_konsumen');
            $table->string('nama_jasa');
            $table->string('nama_barang');
            $table->string('kerusakan');
            $table->string('jenis_perbaikan');
            $table->string('deskripsi');
            $table->string('rating');
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
        Schema::dropIfExists('ulasans');
    }
}
