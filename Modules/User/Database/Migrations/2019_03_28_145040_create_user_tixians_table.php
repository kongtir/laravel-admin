<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTixiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tixians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("uid")->default(0)->comment("用户ID");
            $table->string("icon")->default(0)->comment("来源币种");
            $table->decimal("dot",16,2)->default(0)->comment("来源币种:金额");
            $table->string("for_icon",16,2)->default(0)->comment("提款到");
            $table->decimal("for_dot",16,2)->default(0)->comment("提款到:金额");
            $table->integer("applytime")->default(0)->comment("申请时间");
            $table->integer("passtime")->default(0)->comment("通过时间");
            $table->integer("canceltime")->default(0)->comment("取消时间");
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
        Schema::dropIfExists('user_tixians');
    }
}
