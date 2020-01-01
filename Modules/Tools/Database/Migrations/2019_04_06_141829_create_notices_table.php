<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *php artisan module:migrate Tools
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title",58)->nullable()->default('')->comment("标题");
            $table->string("text",1280)->nullable()->default('')->comment("内容");
            $table->string("author",58)->nullable()->default('')->comment("作者");
            $table->string("img",525)->nullable()->default('')->comment("图片");
            $table->string("link",525)->nullable()->default('')->comment("活动链接");
            $table->unsignedBigInteger("uid")->default(0)->comment("专人通知");
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
        Schema::dropIfExists('notices');
    }
}
