<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("buyid")->default(0)->comment("求购学习豆,购买人id:用RMB买学习豆的人");
            $table->unsignedBigInteger("sellerid")->default(0)->comment("出售学习豆的人");
            $table->integer("seektime")->default(0)->comment("求购时间:1登记求购");
            $table->integer("findtime")->default(0)->comment("点击出售的时间:2卖方点击出售");
            $table->integer("canceltime")->default(0)->comment("取消时间:3任何一方取消交易");
            $table->string("cancelremark",255)->default(0)->comment("取消说明[A方取消:原因()]");
            $table->string("img",255)->default("")->comment("交易凭证:4买家上传凭证,可不上传");
            $table->integer("finishtime")->default(0)->comment("完成时间:5卖家确认收款,学习点到账");
            $table->integer("dot")->default(0)->comment("交易点数");
            $table->integer("rmb")->default(0)->comment("交易价值");
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
        Schema::dropIfExists('study_shops');
    }
}
