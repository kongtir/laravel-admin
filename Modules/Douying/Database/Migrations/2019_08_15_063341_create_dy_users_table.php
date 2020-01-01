<?php use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDyUsersTable extends Migration
{
    /*** Run the migrations.** @return void */
    public function up()
    {
        Schema::create('dy_users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment("用户id");
            $table->string("username", 25)->default("")->comment("用户名,登陆名称");
            $table->string("password", 25)->edittimedefault("")->comment("登录密码");
            $table->string("nickname", 25)->default("")->comment("用户昵称");
            $table->string("truename", 25)->default("")->comment("真实姓名");
            $table->string("phone", 25)->default("")->comment("电话/手机");
            $table->dateTime("edittime")->comment("修改时间");
            $table->dateTime("logintime")->comment("登录时间");
            $table->string("photo", 25)->default("")->comment("头像");
            $table->tinyInteger("status")->default(1)->comment("状态（1.正常 0.禁用）");
            $table->string("yaoqingren", 25)->default("")->comment("邀请人账户");
            $table->string("alipay", 25)->default("")->comment("支付宝账户");
            $table->string("wechat", 25)->default("")->comment("微信账户");
            $table->decimal("dongjie", 15, 2)->default(0)->comment("冻结金额");
            $table->decimal("leijitixian", 15, 2)->default(0)->comment("累计提现");
            $table->decimal("leiji", 15, 2)->default(0)->comment("累计收益");
            $table->decimal("yue", 15, 2)->default(0)->comment("余额");
            $table->decimal("gongxian", 15, 2)->default(0)->comment("已贡献给上级的金额");
            $table->string("icard", 28)->default("")->comment("身份证号");
            $table->string("adress", 255)->default("")->comment("联系地址");
            $table->string("appkey", 45)->default("")->comment("appkey");
            $table->timestamps();
        });
    }

    /*** Reverse the migrations.** @return void */
    public function down()
    {
        Schema::dropIfExists('dy_users');
    }
}