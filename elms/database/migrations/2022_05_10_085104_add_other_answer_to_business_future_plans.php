<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherAnswerToBusinessFuturePlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_future_plans', function (Blueprint $table) {
            $table->string('other_occupation_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_future_plans', function (Blueprint $table) {
            $table->dropColumn('other_occupation_value');
        });
    }
}
