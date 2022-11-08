<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAndServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_and_services', function (Blueprint $table) {
            $table->id();
            $table->integer('sub_sector_id')->unsigned();
            $table->foreign('sub_sector_id')->references('id')->on('economic_sectors');
            $table->string('product_and_services_name');
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
        Schema::dropIfExists('product_and_services');
    }
}
