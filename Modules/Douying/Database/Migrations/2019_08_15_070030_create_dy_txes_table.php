<?php use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDyTxesTable extends Migration
{
    /*** Run the migrations.** @return void */
    public function up()
    {
        Schema::create('dy_txes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("card", 80)->default("")->comment("收款账户");
            $table->string("txtype", 30)->default("")->comment("收款类别:...");
            $table->string("username", 30)->default("")->comment("账户");
            $table->bigInteger("userid")->default(0)->comment("账户ID");
            $table->string("truename", 30)->default("")->comment("真实姓名");
            $table->tinyInteger("status")->default(0)->comment("申请状态:0待审核,1审核通过,2:审核驳回");
            $table->tinyInteger("payed")->default(0)->comment("支付状态:1已支付,0未支付");
            $table->integer("amount")->default(0)->comment("提现金额");
            $table->integer("tax")->default(1)->comment("手续费,默认1元");
            $table->integer("done")->default(0)->comment("处理时间");
            $table->integer("apply")->default(0)->comment("申请时间");
            $table->timestamps();
        });
    }

    /*** Reverse the migrations.** @return void */
    public function down()
    {
        Schema::dropIfExists('dy_txes');
    }
}