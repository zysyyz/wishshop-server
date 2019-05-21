<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique()->nullable();     // 邮箱
            $table->string('username')->unique()->nullable();  // 用户名
            $table->string('password')->nullable();            // 密码
            $table->string('name');                            // 姓名
            $table->boolean('use_gravatar')->default(false);   // 使用 Gravatar 头像
            $table->string('avatar_url')->nullable();          // 头像链接（原始尺寸）
            $table->integer('age')->default(0);                // 年龄
            $table->string('gender')->default('secrecy');      // 性别 [secrecy, male, female]
            $table->string('birthday')->nullable();            // 生日
            $table->string('company')->nullable();             // 公司
            $table->string('website')->nullable();             // 网站
            $table->string('bio')->nullable();                 // 简介
            $table->string('status')->default('active');       // 状态 [active, deactivated, locked]
            $table->boolean('site_admin')->default(false);     // 站点管理员
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
