<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->string('menu_name')->nullable();
            $table->string('menu_controller')->nullable();
            $table->string('menu_link')->nullable();
            $table->string('menu_css')->nullable();
            $table->string('menu_icon')->nullable();
            $table->enum('menu_status',[1,0])->default(1);
            $table->integer('menu_order');
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
        Schema::dropIfExists('menus');
    }
}
