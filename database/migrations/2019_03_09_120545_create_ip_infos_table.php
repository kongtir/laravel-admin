<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip',20)->default("")->comment("ip地址,不区分内外地址")->unique();
            $table->string('adress',255)->default("")->comment("地址");
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
        Schema::dropIfExists('ip_infos');
    }

}
