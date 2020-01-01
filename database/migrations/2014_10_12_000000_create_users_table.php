<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *  php artisan migrate
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment("昵称,真实姓名写另一个表");
            $table->string('email')->unique()->default("");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default("");
            $table->rememberToken();
            $table->timestamps();

            $table->string('phone',15)->unique()->comment("电话");
          //  $table->string('nick',15)->comment("昵称");
            $table->string('token',85)->comment("密钥");
            $table->integer("last")->default(0)->comment("最后登陆");
            $table->bigInteger("sjid")->default(0)->comment("上级ID");
            $table->unsignedInteger("status")->default(1)->comment("0:封号,1:正常");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
