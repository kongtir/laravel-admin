<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->bigInteger('id')->default(0)->comment("用户id")->unsigned()->primary();
            $table->decimal("love",16,4)->comment("爱心点")->default(0);
            $table->decimal("love_shared",16,4)->comment("奉献爱心点:没有签到,可能被他人随机领取")->default(0);
            $table->decimal("love_total",16,4)->comment("累计爱心点")->default(0);

            $table->decimal("wits",16,4)->comment("智慧点")->default(0);
            $table->decimal("wits_total",16,4)->comment("累计智慧点")->default(0);

            $table->decimal("achieves",16,4)->comment("成就点")->default(0);
            $table->decimal("achieves_total",16,4)->comment("累计成就点")->default(0);

            $table->decimal("study",16,4)->comment("学习点")->default(0);
            $table->decimal("study_total",16,4)->comment("累计学习点")->default(0);

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
        Schema::dropIfExists('user_accounts');
    }
}
