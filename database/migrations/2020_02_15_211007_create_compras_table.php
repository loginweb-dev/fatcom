<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComprasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('fecha')->nullable();
			$table->string('nit')->nullable();
			$table->string('razon_social')->nullable();
			$table->integer('nro_factura')->nullable();
			$table->integer('nro_dui')->nullable();
			$table->string('nro_autorizacion')->nullable();
			$table->decimal('importe_compra', 10)->nullable();
			$table->decimal('monto_exento', 10)->nullable();
			$table->decimal('sub_total', 10)->nullable();
			$table->decimal('descuento', 10)->nullable();
			$table->decimal('importe_base', 10)->nullable();
			$table->decimal('credito_fiscal', 10)->nullable();
			$table->string('codigo_control', 20)->nullable();
			$table->string('tipo_compra', 10)->nullable();
			$table->integer('compra_producto')->nullable();
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
		Schema::drop('compras');
	}

}
