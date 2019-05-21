<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->nullable();                // 商店Id
            $table->integer('position')->default(0);                // 位置
            $table->string('slug')->unique()->nullable();           // 缩略名
            $table->string('name');                                 // 名称
            $table->string('logo_url')->nullable();                 // 商标链接（原始尺寸）
            $table->string('image_url')->nullable();                // 图片链接（原始尺寸）
            $table->string('description')->nullable();              // 描述
            $table->string('status')->default('draft');             // 状态 [draft, published]
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
        Schema::dropIfExists('brands');
    }
}
