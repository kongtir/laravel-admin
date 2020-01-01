<?php use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDyConfigsTable extends Migration
{
    /*** Run the migrations.** @return void */
    public function up()
    {
        Schema::create('dy_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("keys", 255)->default("");
            $table->string("value", 525)->default("");
            $table->string("title", 255)->default("");
            $table->string("desc", 255)->default("");
            $table->timestamps();
        });
    }

    /*** Reverse the migrations.** @return void */
    public function down()
    {
        Schema::dropIfExists('dy_configs');
    }
}