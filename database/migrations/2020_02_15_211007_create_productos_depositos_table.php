<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductosDepositosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productos_depositos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('deposito_id')->nullable();
			$table->integer('producto_id')->nullable();
			$table->decimal('stock', 10)->nullable();
			$table->decimal('stock_inicial', 10)->nullable();
			$table->decimal('stock_compra', 10)->nullable()->default(0.00);
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
		Schema::drop('productos_depositos');
	}

}
