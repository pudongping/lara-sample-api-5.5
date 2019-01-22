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
            $table->increments('id')->comment('自增主键id');
            $table->integer('pid')->comment('父级菜单id');
            $table->string('name')->comment('菜单名称');
            $table->string('path')->comment('菜单url');
            $table->string('icon')->comment('菜单图标');
            $table->integer('category_id')->comment('父级分类id');
            $table->tinyInteger('status')->comment('菜单状态：显示或隐藏');
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
