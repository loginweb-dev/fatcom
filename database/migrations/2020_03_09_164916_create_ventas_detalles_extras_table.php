<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasDetallesExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_detalles_extras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('venta_detalle_id')->nullable();
            $table->integer('extra_id')->nullable();
            $table->decimal('cantidad', 10)->nullable();
            $table->decimal('precio', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas_detalles_extras');
    }
}
