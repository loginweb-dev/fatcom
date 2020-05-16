<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOfertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ofertas', function(Blueprint $table)
		{
            $table->integer('tipo_oferta')->nullable()->after('id');
            $table->integer('estado')->nullable()->after('imagen');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ofertas', function (Blueprint $table) {
            $table->dropColumn(['tipo_oferta', 'estado']);
        });
    }
}
