<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfertasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ofertas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre')->nullable();
			$table->text('descripcion', 65535)->nullable();
			$table->string('tipo_duracion', 20)->nullable();
			$table->integer('dia')->nullable();
			$table->dateTime('inicio')->nullable();
			$table->dateTime('fin')->nullable();
			$table->string('imagen')->nullable();
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
		Schema::drop('ofertas');
	}

}
