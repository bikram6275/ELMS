<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('pradesh_id')->unsigned();
            $table->string('district_code');
            $table->string('nepali_name');
            $table->string('english_name')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('pradesh_id')->references('id')->on('pradeshes');
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
        Schema::dropIfExists('districts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    }
}
