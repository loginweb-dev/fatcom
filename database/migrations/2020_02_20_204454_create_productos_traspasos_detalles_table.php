<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTraspasosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_traspasos_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('producto_traspaso_id')->nullable();
            $table->integer('producto_id')->nullable();
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
        Schema::dropIfExists('productos_traspasos_detalles');
    }
}
