<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherValueToOtherOccupationDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_occupation_details', function (Blueprint $table) {
            $table->string('other_value')->nullable();
            $table->integer('occupation_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('other_occupation_details', function (Blueprint $table) {
            $table->dropColumn('other_value');
        });
    }
}
