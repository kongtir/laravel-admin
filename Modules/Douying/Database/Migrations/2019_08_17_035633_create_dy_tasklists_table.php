<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDyTasklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dy_tasklists', function (Blueprint $table) {
            $table->bigIncrements('id');//领取人账户 ID  任务ID[通过详情查看] 领取时间 提交时间 (是否已关闭)  审核结果 预计到账
            $table->string("username", 30)->default("")->comment("账户")->nullable();
            $table->bigInteger("userid")->default(0)->comment("ID");
            $table->bigInteger("taskid")->default(0)->comment("taskid");
            $table->integer("applytime")->default(0)->comment("领取时间");
            $table->integer("subtime")->default(0)->comment("提交时间");
            $table->integer("closetime")->default(0)->comment("截至时间");
            $table->string("status",45)->default("等待提交")->comment("状态,已关闭,未通过,通过");
            $table->string("mark",80)->default("")->comment("原因,备注");
            $table->decimal("reward",15,2)->default(0)->comment("赏金");

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
        Schema::dropIfExists('dy_tasklists');
    }
}
