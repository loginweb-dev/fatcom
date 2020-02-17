<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre')->nullable();
			$table->text('descripcion_small', 65535)->nullable();
			$table->text('descripcion_long', 65535)->nullable();
			$table->decimal('precio_venta', 10)->nullable();
			$table->decimal('precio_minimo', 10)->nullable();
			$table->decimal('ultimo_precio_compra', 10)->nullable();
			$table->string('codigo')->nullable();
			$table->string('codigo_grupo')->nullable();
			$table->string('codigo_barras')->nullable();
			$table->string('estante')->nullable();
			$table->string('bloque')->nullable();
			$table->decimal('stock', 10)->nullable()->default(0.00);
			$table->decimal('stock_minimo', 10)->nullable()->default(0.00);
			$table->string('codigo_interno')->nullable();
			$table->integer('subcategoria_id')->nullable();
			$table->integer('marca_id')->nullable();
			$table->integer('talla_id')->nullable();
			$table->integer('color_id')->nullable();
			$table->integer('genero_id')->nullable();
			$table->integer('unidad_id')->nullable();
			$table->integer('uso_id')->nullable();
			$table->string('modelo')->nullable();
			$table->integer('moneda_id')->nullable();
			$table->string('garantia')->nullable();
			$table->string('catalogo')->nullable();
			$table->integer('nuevo')->nullable();
			$table->integer('se_almacena')->nullable();
			$table->string('imagen')->nullable();
			$table->integer('vistas')->default(0);
			$table->string('slug', 191)->unique('slug');
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
		Schema::drop('productos');
	}

}
