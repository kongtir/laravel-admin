<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_love', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('uid')->default(0)->comment("用户id")->unsigned();
            $table->decimal("change",16,4)->comment("变动金额")->default(0);
            $table->decimal("before",16,4)->comment("变动前")->default(0);
            $table->decimal("after",16,4)->comment("变动后")->default(0);
            $table->string("type",20)->comment("类型")->default("");
            $table->string("remark",125)->comment("备注")->default("");
            $table->string("batch",35)->comment("批号")->default("");
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
        Schema::dropIfExists('user_love');
    }
}
