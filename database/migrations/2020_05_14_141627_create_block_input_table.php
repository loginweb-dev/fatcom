<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_block_input', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('t_block_id');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->text('value')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('t_block_id')->references('id')->on('t_blocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_block_input');
    }
}
