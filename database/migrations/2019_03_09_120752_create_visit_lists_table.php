<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('speed',50)->default("")->comment("下载速度");
            $table->bigInteger('ip_id')->comment("对应ip地址")->unsigned();
           $table->foreign('ip_id')->references('id')->on('ip_infos');

            $table->bigInteger('link_id')->comment("对应link地址")->unsigned();
            $table->foreign('link_id')->references('id')->on('link_infos');

            $table->bigInteger('browser_id')->comment("对应浏览器地址")->unsigned();
            $table->foreign('browser_id')->references('id')->on('browser_infos');

            $table->integer('visitortime')->default(0)->comment("访问者时间");
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
        Schema::dropIfExists('visit_lists');
    }
}
