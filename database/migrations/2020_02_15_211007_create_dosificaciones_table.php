<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDosificacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dosificaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nro_autorizacion', 50)->nullable();
			$table->string('llave_dosificacion')->nullable();
			$table->date('fecha_limite')->nullable();
			$table->integer('numero_inicial')->nullable()->default(1);
			$table->integer('numero_actual')->nullable()->default(1);
			$table->integer('activa')->nullable();
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
		Schema::drop('dosificaciones');
	}

}
