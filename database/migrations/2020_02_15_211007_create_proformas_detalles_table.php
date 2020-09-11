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
			$table->decimal('precio', 8,2)->nullable();
			$table->integer('cantidad')->nullable();
			$table->decimal('subtotal', 8,2)->nullable();
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
