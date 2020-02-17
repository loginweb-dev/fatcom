<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIeCajasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ie_cajas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('sucursal_id')->nullable();
			$table->string('nombre', 50)->nullable();
			$table->text('observaciones', 65535)->nullable();
			$table->date('fecha_apertura')->nullable();
			$table->time('hora_apertura')->nullable();
			$table->date('fecha_cierre')->nullable();
			$table->time('hora_cierre')->nullable();
			$table->decimal('monto_inicial', 10)->nullable();
			$table->decimal('monto_final', 10)->nullable();
			$table->decimal('monto_real', 10)->nullable();
			$table->decimal('monto_faltante', 10)->nullable();
			$table->decimal('total_ingresos', 10)->nullable();
			$table->decimal('total_egresos', 10)->nullable();
			$table->integer('abierta')->nullable();
			$table->integer('user_id')->nullable();
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
		Schema::drop('ie_cajas');
	}

}
