<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enumerator_assign_id')->unsigned();
            $table->foreign('enumerator_assign_id')->references('id')->on('enumeratorassign_pivot');


            $table->integer('qsn_id')->unsigned();
            $table->foreign('qsn_id')->references('id')->on('questions');

            $table->text('answer')->nullable();

            $table->integer('qsn_opt_id')->unsigned()->nullable();
            $table->foreign('qsn_opt_id')->references('id')->on('question_options');

            $table->text('other_answer')->nullable();
            $table->json('other_values')->nullable();
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
        Schema::dropIfExists('answers');
    }
}
