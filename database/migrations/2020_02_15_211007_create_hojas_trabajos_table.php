<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHojasTrabajosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hojas_trabajos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('sucursal_id')->nullable();
			$table->string('codigo')->nullable();
			$table->integer('empleado_id')->nullable();
			$table->integer('estado')->nullable();
			$table->text('observaciones', 65535)->nullable();
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
		Schema::drop('hojas_trabajos');
	}

}
