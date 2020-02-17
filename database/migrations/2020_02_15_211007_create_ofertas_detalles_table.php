<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfertasDetallesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ofertas_detalles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('oferta_id')->nullable();
			$table->integer('producto_id')->nullable();
			$table->string('tipo_descuento')->nullable();
			$table->decimal('monto', 10)->nullable();
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
		Schema::drop('ofertas_detalles');
	}

}
