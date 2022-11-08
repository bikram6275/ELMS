<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fy_id')->unsigned();
            $table->foreign('fy_id')->references('id')->on('fiscal_years');
            $table->string('survey_name');
            $table->year('survey_year');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            // $table->enum('survey_completed',['yes','no']);
            // $table->integer('participant_number');
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
        Schema::dropIfExists('surveys');
    }
}
