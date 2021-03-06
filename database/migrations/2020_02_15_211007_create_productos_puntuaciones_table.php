<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductosPuntuacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productos_puntuaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('producto_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('puntos')->nullable();
			$table->text('comentario', 65535)->nullable();
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
		Schema::drop('productos_puntuaciones');
	}

}
