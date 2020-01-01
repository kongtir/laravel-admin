<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTChecksTable extends Migration
{
    /**
     * 单独生成:不建议这么做
     * php artisan module:make-migration create_t_checks_table Tools
     * Run the migrations.
     * 迁移命令
     *php artisan module:migrate Tools
     * 模块：迁移回滚
     * php artisan module:migrate-rollback Blog
     * 模块：迁移刷新
     * php artisan module:migrate-refresh Blog  会清除所有数据并重新创建表
     * 重置给定模块的迁移，或者没有指定的模块重置所有模块迁移。
     * php artisan module:migrate-reset Blog
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_checks', function (Blueprint $table) {
            $table->bigIncrements('id');
            //手机验证码 验证码后设置为空
            //图形验证码 验证码后设置为空
            //手机验证码时间戳
            //图形验证码时间戳
            //对应userid 默认0
            //appkey 标识
            $table->string("phone",20)->default("");
            $table->string("smscode",20)->default("");
            $table->string("imgcode",20)->default("");
            $table->integer("smstime")->default(0);
            $table->integer("imgtime")->default(0);
            $table->bigInteger("user_id")->default(0);
            $table->string("appkey",120)->default("")->unique();
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
        Schema::dropIfExists('t_checks');
    }
}
