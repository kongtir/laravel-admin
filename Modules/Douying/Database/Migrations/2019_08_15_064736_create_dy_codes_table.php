<?php use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDyCodesTable extends Migration
{
    /*** Run the migrations.** @return void */
    public function up()
    {
        Schema::create('dy_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger("yishou")->default(0)->comment("未出售:0,已出售:1");
            $table->tinyInteger("used")->default(0)->comment("未使用:0,已使用:1");
            $table->string("username", 30)->default("")->comment("使用该激活码的用户");
            $table->bigInteger("userid")->default(0)->comment("使用激活码的用户");
            $table->string("phone", 30)->default("")->comment("手机号");
            $table->string("keys", 30)->default("")->comment("密钥");
            $table->string("psd", 30)->default("")->comment("密码");
            $table->integer("selltime")->default(0)->comment("销售时间");
            $table->integer("usetime")->default(0)->comment("使用时间");
            $table->string("marks", 30)->default("")->comment("备注");
            $table->decimal("gongzi", 15, 4)->default(0)->comment("该激活码已获得的工资");
            $table->tinyInteger("status")->default(0)->comment("0:禁用;1启用");

            $table->timestamps();
        });
    }

    /*** Reverse the migrations.** @return void */
    public function down()
    {
        Schema::dropIfExists('dy_codes');
    }
}