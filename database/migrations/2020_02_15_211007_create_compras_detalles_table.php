<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComprasDetallesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compras_detalles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compra_id')->unsigned()->nullable()->index();
			$table->string('producto_id')->nullable();
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
		Schema::drop('compras_detalles');
	}

}
