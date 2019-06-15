<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->nullable();                // 商店Id
            $table->integer('user_id');                             // 用户Id
            $table->string('full_name')->nullable();                // 命名
            $table->string('first_name')->nullable();               // 名字
            $table->string('last_name')->nullable();                // 姓
            $table->string('email')->nullable();                    // 邮箱
            $table->string('phone_number')->nullable();             // 手机号
            $table->string('country')->nullable();                  // 国家
            $table->string('province')->nullable();                 // 省
            $table->string('city')->nullable();                     // 城市
            $table->string('district')->nullable();                 // 区
            $table->string('line1')->nullable();                    // 地址1（通常是街道名称）
            $table->string('line2')->nullable();                    // 地址2（通常是单位或公寓号码）
            $table->string('postal_code')->nullable();;             // 邮政编码
            $table->boolean('as_default')->default(false);          // 作为默认地址
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
        Schema::dropIfExists('addresses');
    }
}
