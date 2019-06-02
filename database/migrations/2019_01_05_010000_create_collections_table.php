<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->nullable();                // 商店Id
            $table->string('slug')->unique()->nullable();           // 缩略名
            $table->string('name')->nullable();                     // 名称
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
        Schema::dropIfExists('collections');
    }
}
