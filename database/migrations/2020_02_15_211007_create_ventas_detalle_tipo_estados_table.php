<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVentasDetalleTipoEstadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas_detalle_tipo_estados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('venta_tipo_id')->nullable();
			$table->integer('venta_estado_id')->nullable();
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
		Schema::drop('ventas_detalle_tipo_estados');
	}

}
