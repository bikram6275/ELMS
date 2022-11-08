<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_award', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->integer('org_id')->unsigned();
            $table->string('grade_earned')->nullable();
            $table->string('promotion_received')->nullable();
            $table->enum('appreciation_letter',['1','0'])->nullable()->default('0');
            $table->enum('employee_of_yr',['1','0'])->nullable()->default('0');
            $table->integer('fy_id')->unsigned();
            $table->foreign('fy_id')->references('id')->on('fiscal_years');
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
        Schema::dropIfExists('employee_award');
    }
}
