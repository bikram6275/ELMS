<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalHumanResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_human_resources', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('enumerator_assign_id')->unsigned();
            $table->foreign('enumerator_assign_id')->references('id')->on('enumeratorassign_pivot');

            $table->enum('gender',['male','female']);
            $table->string('emp_name')->nullable();

            // $table->integer('sector_id')->unsigned();
            // $table->foreign('sector_id')->references('id')->on('economic_sectors');

            $table->integer('occupation_id')->unsigned();
            $table->foreign('occupation_id')->references('id')->on('occupations');
            // $table->string('occupation');

            $table->enum('working_time',['full','part']);
            $table->enum('work_nature',['regular','seasonal']);
            $table->enum('training',['trained','untrained']);
            $table->string('ojt_apprentice');

            $table->integer('edu_qua_id')->unsigned();
            $table->foreign('edu_qua_id')->references('id')->on('educational_qualifications');

            $table->string('work_exp1')->nullable()->comment('Present Position');
            $table->string('work_exp2')->nullable()->comment('In this Occupation');
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
        Schema::dropIfExists('technical_human_resources');
    }
}
