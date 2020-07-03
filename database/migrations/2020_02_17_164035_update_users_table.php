<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
		{
            $table->integer('localidad_id')->nullable()->after('role_id');
			$table->integer('cliente_id')->nullable()->after('role_id');
            $table->string('tipo_login')->nullable()->after('settings');
            $table->string('firebase_token')->nullable()->after('remember_token');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cliente_id', 'localidad_id', 'tipo_login']);
        });
    }
}
