<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumosDepositosRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos_depositos_registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('insumo_deposito_id')->nullable();
            $table->decimal('cantidad', 10)->nullable();
            $table->decimal('precio', 10)->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('insumos_depositos_registros');
    }
}
