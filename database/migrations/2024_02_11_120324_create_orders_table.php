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
            $table->integer('invoice');
            $table->integer('id_konsumen');
            $table->integer('grand_total');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('orders_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_order');
            $table->integer('id_jasa');
            $table->timestamp('tgl_perbaikan');
            $table->integer('jumlah');
            $table->integer('total');
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
