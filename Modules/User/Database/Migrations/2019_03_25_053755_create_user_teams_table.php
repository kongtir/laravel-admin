<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("sep")->default(0)->comment("次序");
            $table->string("name",50)->default("")->comment("名字");
            $table->string("desc",255)->default("")->comment("描述文字");
            $table->string("img",255)->default("")->comment("图片");
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
        Schema::dropIfExists('user_teams');
    }
}
