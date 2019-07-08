<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id');                            // 商店Id
            $table->integer('user_id');                             // 用户Id
            $table->string('number')->nullable();                   // 订单号
            $table->string('reference_number')->nullable();         // 参考编号
            $table->double('subtotal')->default(0);                 // 小计
            $table->double('total')->ndefault(0);                   // 总计
            $table->double('number_of_items')->default(0);          // 项目数
            $table->string('status')->default('pending');           // 状态 [pending, cancelled, completed]
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
        Schema::dropIfExists('orders');
    }
}
