<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProformasDetallesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proformas_detalles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('proforma_id')->nullable();
			$table->integer('producto_id')->nullable();
			$table->decimal('precio', 10)->nullable();
			$table->decimal('cantidad', 10)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('proformas_detalles');
	}

}
