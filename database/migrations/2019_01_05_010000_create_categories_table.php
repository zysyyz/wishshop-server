<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->nullable();                // 商店Id
            $table->integer('parent_id')->default(0);               // 父分类Id
            $table->integer('level')->default(0);                   // 级别
            $table->integer('position')->default(0);                // 位置
            $table->string('slug')->unique()->nullable();           // 缩略名
            $table->string('name');                                 // 名称
            $table->string('image_url')->nullable();                // 图片链接（原始尺寸）
            $table->string('description')->nullable();              // 描述
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
        Schema::dropIfExists('categories');
    }
}
