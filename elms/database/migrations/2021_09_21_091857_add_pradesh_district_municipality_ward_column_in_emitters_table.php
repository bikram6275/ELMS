<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPradeshDistrictMunicipalityWardColumnInEmittersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emitters', function (Blueprint $table) {

            $table->integer('pradesh_id')->unsigned();
//            $table->foreign('pradesh_id')->references('id')->on('pradeshes');

            $table->integer('district_id')->unsigned();
//            $table->foreign('district_id')->references('id')->on('districts');

            $table->integer('muni_id')->unsigned();
//            $table->foreign('muni_id')->references('id')->on('municipalities');

            $table->integer('ward_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emitters', function (Blueprint $table) {
            Schema::dropIfExists('emitters');
        });
    }
}
