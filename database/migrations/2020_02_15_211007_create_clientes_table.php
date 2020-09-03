<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('razon_social')->nullable();
			$table->string('nit')->nullable();
			$table->string('code_movil')->default('+591');
			$table->string('movil')->nullable();
			$table->string('direccion')->nullable();
			$table->string('ubicacion')->nullable();
			$table->string('descripcion')->nullable();
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
		Schema::drop('clientes');
	}

}
