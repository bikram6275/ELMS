<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_skills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enumerator_assign_id')->unsigned();
            $table->foreign('enumerator_assign_id')->references('id')->on('enumeratorassign_pivot');
            $table->string('skill');
            $table->integer('formally_trained');
            $table->integer('formally_untrained');
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
        Schema::dropIfExists('worker_skills');
    }
}
