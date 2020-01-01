<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrowserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('browser_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('browser',255)->default("")->comment("浏览器和系统");
            $table->string('agent',255)->default("")->comment("浏览器头userAgent");
            $table->string('language',255)->default("")->comment("语言");
            $table->string('screen',255)->default("")->comment("屏幕");
            $table->string('vendor',255)->default("")->comment("vendor");
            $table->string('plugin',255)->default("")->comment("pluginName")->nullable();
            $table->string('os',255)->default("")->comment("OS");
            $table->boolean('wechat')->default(false)->comment("是否是微信");
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
        Schema::dropIfExists('browser_infos');
    }
}
