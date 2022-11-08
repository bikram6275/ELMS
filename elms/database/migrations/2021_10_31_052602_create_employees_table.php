<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_name');
            $table->date('date_of_birth')->nullable();
            $table->string('gender');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('grand_father_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->integer('no_of_children')->nullable();
            $table->enum('marital_status', ['married', 'unmarried']);
            $table->integer('permanent_pradesh_id')->unsigned();
            $table->foreign('permanent_pradesh_id')->references('id')->on('pradeshes');
            $table->integer('permanent_district_id')->unsigned();
            $table->foreign('permanent_district_id')->references('id')->on('districts');
            $table->integer('permanent_muni_id')->unsigned();
            $table->foreign('permanent_muni_id')->references('id')->on('municipalities');
            $table->integer('permanent_ward_no')->nullable();
            $table->integer('pradesh_id')->unsigned();
            $table->foreign('pradesh_id')->references('id')->on('pradeshes');
            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts');
            $table->integer('muni_id')->unsigned();
            $table->foreign('muni_id')->references('id')->on('municipalities');
            $table->integer('ward_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->string('first_entry_position');
            $table->string('level');
            $table->string('promoted_level')->nullable();
            $table->string('present_position');
            $table->date('immediate_promoted_date')->nullable();
            $table->string('working_hour_per_week')->nullable();
            $table->string('working_hour_per_days_in_month')->nullable();
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->date('join_date')->nullable();
            $table->integer('employee_type_id')->unsigned();
            $table->foreign('employee_type_id')->references('id')->on('employment_types');

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
        Schema::dropIfExists('employees');
    }
}
