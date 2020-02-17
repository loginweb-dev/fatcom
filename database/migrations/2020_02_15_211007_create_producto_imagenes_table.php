<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductoImagenesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('producto_imagenes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('producto_id')->nullable();
			$table->text('imagen', 65535)->nullable();
			$table->string('tipo')->nullable();
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
		Schema::drop('producto_imagenes');
	}

}
