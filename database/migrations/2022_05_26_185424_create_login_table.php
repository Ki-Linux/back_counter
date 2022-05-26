<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('mail', 50);
            $table->string('username', 20);
            $table->string('password', 100);
            $table->string('random', 255);
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
        Schema::create('login', function (Blueprint $table) {
            //
            $table->dropColumn('mail', 50);
            $table->dropColumn('username', 20);
            $table->dropColumn('password', 100);
            $table->dropColumn('random', 255);
        });
    }
}
