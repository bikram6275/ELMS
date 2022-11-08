<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnologyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technology_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enumerator_assign_id')->unsigned();
            $table->foreign('enumerator_assign_id')->references('id')->on('enumeratorassign_pivot');

            $table->integer('sector_id')->unsigned();
            $table->foreign('sector_id')->references('id')->on('economic_sectors');

            $table->text('technology');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technology_details');
    }
}
