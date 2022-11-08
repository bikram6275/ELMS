<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_experiences', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
//            $table->integer('experience_tag_id')->unsigned();
//            $table->foreign('experience_tag_id')->references('id')->on('experience_tags');
//            $table->year('year')->nullable();
//            $table->integer('month')->nullable();
            $table->string('present_org_year');
            $table->string('present_org_month');
            $table->string('same_occu_year');
            $table->string('same_occu_month');
            $table->string('present_pos_year');
            $table->string('present_pos_month');
            $table->string('other_org_year');
            $table->string('other_org_month');
            $table->string('total_exp_year');
            $table->string('total_exp_month');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations');
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
        Schema::dropIfExists('employee_experiences');
    }
}
