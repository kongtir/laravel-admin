<?php use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDyNewsTable extends Migration
{
    /*** Run the migrations.** @return void */
    public function up()
    {
        Schema::create('dy_news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("title", 100)->default("")->comment("标题");
            $table->string("author", 30)->default("官方团队")->comment("发布者");
            $table->string("types", 30)->default("公告")->comment("分类");
            $table->string("introduce", 150)->default("")->comment("内容简介");
            $table->text("centent", 4500)->nullable()->comment("内容");
            $table->integer("hits")->default(0)->comment("点击次数");
            $table->tinyInteger("status")->default(1)->comment("状态（1显示 0不显示）");
            $table->integer("addtime")->default(0)->comment("发布时间");
            $table->timestamps();
        });
    }

    /*** Reverse the migrations.** @return void */
    public function down()
    {
        Schema::dropIfExists('dy_news');
    }
}