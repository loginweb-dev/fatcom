<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEcommerceEnviosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ecommerce_envios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('ecommerce_producto_id')->nullable();
			$table->integer('localidad_id')->nullable();
			$table->integer('precio')->nullable();
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
		Schema::drop('ecommerce_envios');
	}

}
