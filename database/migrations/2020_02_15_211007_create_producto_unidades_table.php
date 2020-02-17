<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductoUnidadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('producto_unidades', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('unidad_id')->nullable();
			$table->integer('producto_id')->nullable();
			$table->decimal('precio', 10)->nullable();
			$table->decimal('precio_minimo', 10)->nullable();
			$table->integer('cantidad_pieza')->nullable()->default(1);
			$table->integer('cantidad_minima')->nullable()->default(1);
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
		Schema::drop('producto_unidades');
	}

}
