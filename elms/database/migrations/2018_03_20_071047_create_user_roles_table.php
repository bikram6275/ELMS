<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_group_id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->enum('allow_view',[1,0])->default(1);
            $table->enum('allow_add',[1,0])->default(1);
            $table->enum('allow_edit',[1,0])->default(1);
            $table->enum('allow_delete',[1,0])->default(1);
            $table->foreign('user_group_id')->references('id')->on('user_groups')->onUpdate('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->onUpdate('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('user_roles');
    }
}
