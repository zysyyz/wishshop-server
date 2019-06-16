<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModifierOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifier_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');                            // 商店Id
            $table->integer('product_id')->nullable();              // 商品Id
            $table->integer('modifier_id')->nullable();             // 附加选项Id
            $table->string('code')->nullable();                     // 选项编号
            $table->string('image_url')->nullable();                // 图片链接（原始尺寸）
            $table->string('option_name')->nullable();              // 选项名称
            $table->string('option_value')->nullable();             // 选项值
            $table->double('change_in_price')->default(0);          // 价格变动
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
        Schema::dropIfExists('modifier_options');
    }
}
