<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtrasTraspasosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extras_traspasos_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('extra_traspaso_id')->nullable();
            $table->integer('extra_id')->nullable();
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
        Schema::dropIfExists('extras_traspasos_detalles');
    }
}
