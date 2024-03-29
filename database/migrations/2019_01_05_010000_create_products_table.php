<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');                            // 商店Id
            $table->integer('brand_id')->nullable();                // 品牌Id
            $table->string('brand_name')->nullable();               // 品牌名称
            $table->integer('category_id')->nullable();             // 分类Id
            $table->string('slug')->unique()->nullable();           // 缩略名
            $table->string('name');                                 // 名称
            $table->string('image_url')->nullable();                // 图片链接（原始尺寸）
            $table->string('summary')->nullable();                  // 概述
            $table->text('description')->nullable();                // 描述
            $table->json('tags')->nullable();                       // 标签
            $table->string('sku')->nullable();                      // SKU
            $table->double('price')->default(0);                    // 价格
            $table->double('original_price')->nullable();           // 原价
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
        Schema::dropIfExists('products');
    }
}
