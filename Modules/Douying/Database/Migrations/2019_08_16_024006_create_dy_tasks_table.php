<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDyTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dy_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("nickname", 30)->default("")->comment("昵称");
            $table->string("username", 30)->default("")->comment("账户")->nullable();
            $table->bigInteger("userid")->default(0)->comment("0 表示模拟数据");
            $table->string("types", 30)->default("抖音点赞")->comment("类别:抖音点赞,快手点赞");
            $table->double("maxreward", 15,2)->default(0)->comment("最大赏金");
            $table->integer("total")->default(0)->comment("总数量");
            $table->integer("balance")->default(0)->comment("剩余数量");
            $table->tinyInteger("top")->default(1)->comment("是否置顶:0,1置顶");
            $table->tinyInteger("status")->default(1)->comment("是否可用:0,1可用");
            $table->string("mark", 800)->default("")->comment("任务描述");
            $table->string("url", 800)->default("")->comment("任务链接")->nullable();
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
        Schema::dropIfExists('dy_tasks');
    }
}
