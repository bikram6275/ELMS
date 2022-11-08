<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToEnumeratorAssign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enumeratorassign_pivot', function (Blueprint $table) {
            $table->enum('status',['supervised','unsupervised','field_supervised','feedback'])->default('unsupervised');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enumeratorassign_pivot', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
