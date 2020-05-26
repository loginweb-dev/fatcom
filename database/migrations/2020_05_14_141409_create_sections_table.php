<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('t_page_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->nullable();
            $table->integer('visible')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('t_page_id')->references('id')->on('t_pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_sections');
    }
}
