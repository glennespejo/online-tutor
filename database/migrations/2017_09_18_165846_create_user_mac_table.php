<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_macs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mac_address');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('agreement')->default('disagree');
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
        Schema::dropIfExists('user_mac');
    }
}
