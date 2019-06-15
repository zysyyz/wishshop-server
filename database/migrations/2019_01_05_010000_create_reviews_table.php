<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->nullable();                // 商店Id
            $table->integer('user_id')->nullable();                 // 用户Id
            $table->integer('product_id')->nullable();              // 商品Id
            $table->integer('order_id')->nullable();                // 订单Id
            $table->text('content')->nullable();                    // 内容
            $table->double('rate')->default(5);                     // 评分
            $table->json('tags')->nullable();                       // 标签
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
        Schema::dropIfExists('reviews');
    }
}
