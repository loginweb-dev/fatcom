<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductosInsumosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productos_insumos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('producto_id')->nullable();
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
		Schema::drop('productos_insumos');
	}

}
