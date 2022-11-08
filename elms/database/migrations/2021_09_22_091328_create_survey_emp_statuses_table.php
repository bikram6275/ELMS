<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyEmpStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_emp_statuses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('enumerator_assign_id')->unsigned();
            $table->foreign('enumerator_assign_id')->references('id')->on('enumeratorassign_pivot');

            $table->integer('occupation_id')->unsigned();
            $table->foreign('occupation_id')->references('id')->on('occupations');

            $table->integer('working_number')->default(0);
            $table->integer('required_number')->default(0);
            $table->integer('for_two_years')->default(0);
            $table->integer('for_five_years')->default(0);

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
        Schema::dropIfExists('survey_emp_statuses');
    }
}
