<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePreciosComprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('precios_compras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('monto', 10)->nullable();
			$table->decimal('cantidad_minima', 10)->nullable();
			$table->integer('producto_id')->nullable();
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
		Schema::drop('precios_compras');
	}

}
