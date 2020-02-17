<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientesCoordenadasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes_coordenadas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->nullable();
			$table->string('lat')->nullable();
			$table->string('lon')->nullable();
			$table->text('descripcion', 65535)->nullable();
			$table->integer('concurrencia')->nullable();
			$table->integer('ultima_ubicacion')->nullable();
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
		Schema::drop('clientes_coordenadas');
	}

}
