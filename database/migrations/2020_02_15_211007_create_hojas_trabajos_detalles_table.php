<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHojasTrabajosDetallesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hojas_trabajos_detalles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('hoja_trabajo_id')->nullable();
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
		Schema::drop('hojas_trabajos_detalles');
	}

}
