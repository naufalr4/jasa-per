<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJasaPerbaikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jasa__perbaikans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kategori');
            $table->integer('id_subkategori');
            $table->string('nama_jasa');
            $table->string('gambar');
            $table->text('deskripsi');
            $table->string('Jam_Buka');
            $table->integer('estimasi_harga');

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
        Schema::dropIfExists('jasa__perbaikans');
    }
}
