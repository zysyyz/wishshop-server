<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->nullable();                // 商店Id
            $table->integer('product_id')->nullable();              // 商品Id
            $table->integer('position')->default(0);                // 位置
            $table->string('type')->nullable();                     // 类型
            $table->string('content')->nullable();                  // 内容
            $table->json('meta')->nullable();                       // 元数据
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
        Schema::dropIfExists('contents');
    }
}
