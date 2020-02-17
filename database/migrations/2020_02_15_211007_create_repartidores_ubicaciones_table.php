<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepartidoresUbicacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('repartidores_ubicaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('repartidor_pedido_id')->nullable();
			$table->string('lat')->nullable();
			$table->string('lon')->nullable();
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
		Schema::drop('repartidores_ubicaciones');
	}

}
