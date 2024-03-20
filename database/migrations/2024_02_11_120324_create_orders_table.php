<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('id_perbaikan');
            $table->integer('nama_jasa');
            $table->string('nama_konsumen');
            $table->integer('grand_total_estimasi_harga');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('orders_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_perbaikan');
            $table->string('nama_konsumen');
            $table->integer('no_tlp');
            $table->text('alamat');
            $table->string('nama_jasa');
            $table->string('nama_barang');
            $table->string('kerusakan');
            $table->string('jenis_perbaikan');
            $table->date('tgl_perbaikan');
            $table->integer('total_estimasi_harga');
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
        Schema::dropIfExists('orders');
    }
}
