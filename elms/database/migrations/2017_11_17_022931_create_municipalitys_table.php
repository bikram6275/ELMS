<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipalitysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipalities', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('muni_type_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->string('muni_code')->nullable();
            $table->string('muni_name')->nullable();
            $table->string('muni_name_en')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('muni_type_id')->references('id')->on('muni_types');
            $table->foreign('district_id')->references('id')->on('districts');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('municipalities');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
