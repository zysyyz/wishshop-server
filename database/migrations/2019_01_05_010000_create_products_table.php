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
            $table->integer('store_id')->nullable();                // 商店Id
            $table->integer('brand_id')->nullable();                // 品牌Id
            $table->string('brand_name')->nullable();               // 品牌名称
            $table->string('slug')->unique()->nullable();           // 缩略名
            $table->string('name');                                 // 名称
            $table->string('image_url')->nullable();                // 图片链接（原始尺寸）
            $table->string('description')->nullable();              // 描述
            $table->string('sku')->nullable();                      // SKU
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
