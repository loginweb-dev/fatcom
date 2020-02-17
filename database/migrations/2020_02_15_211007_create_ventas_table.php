<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVentasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('sucursal_id')->nullable();
			$table->integer('nro_venta')->nullable();
			$table->integer('cliente_id')->nullable();
			$table->date('fecha')->nullable();
			$table->string('nro_factura')->nullable();
			$table->string('codigo_control')->nullable();
			$table->string('estado')->nullable();
			$table->string('nro_autorizacion')->nullable();
			$table->date('fecha_limite')->nullable();
			$table->decimal('importe', 10)->nullable();
			$table->decimal('importe_ice', 10)->nullable();
			$table->decimal('importe_exento', 10)->nullable();
			$table->decimal('tasa_cero', 10)->nullable();
			$table->decimal('subtotal', 10)->nullable();
			$table->decimal('descuento', 10)->nullable();
			$table->decimal('importe_base', 10)->nullable();
			$table->decimal('debito_fiscal', 10)->nullable();
			$table->decimal('cobro_adicional', 10)->nullable();
			$table->integer('cobro_adicional_factura')->nullable();
			$table->integer('caja_id')->nullable();
			$table->integer('pagada')->default(1);
			$table->integer('efectivo')->nullable()->default(1);
			$table->integer('user_id')->nullable();
			$table->integer('venta_tipo_id')->nullable();
			$table->integer('venta_estado_id')->default(1);
			$table->integer('nro_mesa')->nullable();
			$table->integer('autorizacion_id')->nullable();
			$table->decimal('monto_recibido', 10)->nullable();
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
		Schema::drop('ventas');
	}

}
