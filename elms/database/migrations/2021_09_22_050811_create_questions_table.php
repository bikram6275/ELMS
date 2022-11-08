<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->string('qsn_number');
            $table->text('qsn_name');
            $table->enum('ans_type',['input','radio','checkbox','multiple_input','table','range','other_values','external_table','sector','services','sub_qsn','cond_radio']);
            $table->enum('qst_status',['active','inactive']);
            $table->enum('required',['yes','no'])->default('no');
            $table->text('instruction')->nullable();
            $table->enum('qsn_modify',['yes','no'])->default('yes');
            $table->integer('qsn_order');

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
        Schema::dropIfExists('questions');
    }
}
