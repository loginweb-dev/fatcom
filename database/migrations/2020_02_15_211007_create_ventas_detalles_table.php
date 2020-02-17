<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVentasDetallesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas_detalles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('venta_id')->nullable();
			$table->integer('producto_id')->nullable();
			$table->decimal('precio', 10)->nullable();
			$table->decimal('cantidad', 10)->nullable();
			$table->integer('producto_adicional')->nullable();
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
		Schema::drop('ventas_detalles');
	}

}
