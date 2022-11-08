<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->integer('qsn_id')->unsigned();
            $table->foreign('qsn_id')->references('id')->on('questions');

            $table->string('option_number');
            $table->text('option_name');
            $table->integer('option_order');
            $table->enum('option_type',['json','input','radio','sector','cond_radio','checkbox','others']);
            $table->text('options')->nullable();
            $table->text('remarks')->nullable();


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
        Schema::dropIfExists('question_options');
    }
}
