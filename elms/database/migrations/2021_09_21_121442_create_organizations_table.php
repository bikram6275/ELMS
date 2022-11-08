<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('org_name');

            $table->integer('sector_id')->unsigned();
            $table->foreign('sector_id')->references('id')->on('economic_sectors');

            $table->string('pan_number');
            $table->string('licensce_no');

            $table->integer('pradesh_id')->unsigned();
            $table->foreign('pradesh_id')->references('id')->on('pradeshes');

            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts');

            $table->integer('muni_id')->unsigned();
            $table->foreign('muni_id')->references('id')->on('municipalities');

            $table->integer('ward_no');
            $table->string('tole')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->date('establish_date');



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
        Schema::dropIfExists('organizations');
    }
}
