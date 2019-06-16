<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifiers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');                            // 商店Id
            $table->integer('product_id')->nullable();              // 商品Id
            $table->string('title');                                // 标题
            $table->string('option_type')->nullable();              // 选项类型
            $table->string('option_format')->nullable();            // 选项格式
            $table->string('option_unit')->nullable();              // 选项单位
            $table->string('choose_type')->default('single');       // 选择类型 [single, multiple]
            $table->integer('choose_at_least')->nullable();         // 至少选择数
            $table->integer('choose_up_to')->nullable();            // 最多选择数
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
        Schema::dropIfExists('modifiers');
    }
}
