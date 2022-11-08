<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnumeratorAssignPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enumeratorassign_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emitter_id')->nullable();
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('survey_id');

            $table->string('supervisor_name')->nullable();
            $table->date('supervising_date')->nullable();

            $table->string('respondent_name')->nullable();
            $table->string('designation')->nullable();
            $table->date('interview_date')->nullable();

            $table->string('start_date')->nullable();
            $table->string('finish_date')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreign('emitter_id')->references('id')->on('emitters')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
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
        Schema::dropIfExists('enumeratorassign_pivot');
    }
}
