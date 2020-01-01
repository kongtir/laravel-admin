<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_sys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("keys",20)->default("")->comment("键")->unique();
            $table->string("value",20)->default("")->comment("值");
            $table->string("title",20)->default("")->comment("标题");
            $table->string("desc",80)->default("")->comment("说明");
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
        Schema::dropIfExists('config_sys');
    }
}
