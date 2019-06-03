<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique()->nullable();           // 缩略名
            $table->string('name');                                 // 名称
            $table->text('description')->nullable();                // 描述
            $table->string('logo_url')->nullable();                 // 商标链接（原始尺寸）
            $table->string('image_url')->nullable();                // 图片链接（原始尺寸）
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
        Schema::drop('stores');
    }
}
