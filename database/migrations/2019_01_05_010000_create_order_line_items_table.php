<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_line_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');                            // 商店Id
            $table->integer('user_id');                             // 用户Id
            $table->string('purchase_type')->nullable();            // 购买类型
            $table->string('purchase_id')->nullable();              // 购买类型
            $table->string('label')->nullable();                    // 标签
            $table->double('price')->default(0);                    // 价格
            $table->double('original_price')->nullable();           // 原价
            $table->double('quantity')->default(0);                 // 数量
            $table->double('subtotal')->default(0);                 // 小计
            $table->double('total')->ndefault(0);                   // 总计
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
        Schema::dropIfExists('order_line_items');
    }
}
