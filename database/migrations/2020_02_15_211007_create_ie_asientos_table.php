<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIeAsientosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ie_asientos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('concepto', 65535)->nullable();
			$table->decimal('monto', 10)->nullable();
			$table->string('tipo', 20)->nullable();
			$table->date('fecha')->nullable();
			$table->time('hora')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('caja_id')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('venta_id')->nullable();
			$table->integer('compra_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ie_asientos');
	}

}
