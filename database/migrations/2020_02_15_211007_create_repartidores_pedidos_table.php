<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepartidoresPedidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('repartidores_pedidos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('repartidor_id')->nullable();
			$table->integer('pedido_id')->nullable();
			$table->integer('estado')->nullable();
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
		Schema::drop('repartidores_pedidos');
	}

}
