<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigInteger('id')->default(0)->comment("用户id")->unsigned()->primary();
            //$table->foreign('id')->references('id')->on('users'); //外键
            $table->string("truename",25)->default("")->comment("真实姓名");
            $table->string("qq",22)->default("")->comment("QQ");
            $table->string("wechat",45)->default("")->comment("微信");
            $table->string("mail",45)->default("")->comment("邮箱");
            $table->string("alipay",25)->default("")->comment("支付宝");
            $table->string("icard",28)->default("")->comment("身份证号");

            $table->string("adress",255)->default("")->comment("联系地址");
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
        Schema::dropIfExists('user_details');
    }
}
