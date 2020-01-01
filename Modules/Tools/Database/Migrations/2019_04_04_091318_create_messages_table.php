<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("send",58)->default("")->comment("发送人appkey");
            $table->unsignedBigInteger("sendid")->default(0)->comment("发送人id,不一定有");
            $table->string("att",58)->default("")->comment("接收人appkey");
            $table->unsignedBigInteger("attid")->default(0)->comment("接收人id,不一定有");
            $table->string("text",1024)->default('')->comment("文本");
            $table->string("img",525)->default('')->comment("图片");
            $table->unsignedInteger("read")->default(0)->comment("未读:0,已读1");
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
        Schema::dropIfExists('messages');
    }
}
