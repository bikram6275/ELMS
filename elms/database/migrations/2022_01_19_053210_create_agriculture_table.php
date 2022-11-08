<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgricultureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agriculture', function (Blueprint $table) {
            $table->id();
            $table->integer('sn')->unique();
            $table->string('name_of_member_enterprises');
            $table->string('associated_association');
            $table->string('sector');
            $table->string('district');
            $table->string('local_level')->nullable();
            $table->string('ward_no')->nullable();
            $table->string('scale_of_industry')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('agriculture');
    }
}
