<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCalculatorsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_calculators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("price")->default(0)->comment("价格,消耗爱心点");
            $table->string("name",255)->default("")->comment("计算名称");
            $table->string("url",255)->default("")->comment("访问地址");
            $table->string("img",255)->default("")->comment("计算器图片");
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
        Schema::dropIfExists('t_calculators');
    }
}
