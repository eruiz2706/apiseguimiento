<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_rol', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('role_id')->unsigned()->index();
          $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
          $table->integer('menu_id')->unsigned()->index();
          $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
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
        Schema::dropIfExists('menu_rol');
    }
}
