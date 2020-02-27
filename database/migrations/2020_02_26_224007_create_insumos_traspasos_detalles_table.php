<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumosTraspasosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos_traspasos_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('insumo_traspaso_id')->nullable();
            $table->integer('insumo_id')->nullable();
            $table->decimal('cantidad', 10)->nullable();
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
        Schema::dropIfExists('insumos_traspasos_detalles');
    }
}
