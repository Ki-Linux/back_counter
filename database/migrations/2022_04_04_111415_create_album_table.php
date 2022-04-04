<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('username', 20);
            $table->string('image', 100);
            $table->string('selector', 10);
            $table->integer('target');
            $table->integer('present');
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
        Schema::table('albums', function (Blueprint $table) {
            //
            $table->dropColumn('id');
            $table->dropColumn('username', 20);
            $table->dropColumn('image', 100);
            $table->dropColumn('selector', 10);
            $table->dropColumn('target');
            $table->dropColumn('present');
            $table->dropColumn('timestamps');
        });
    }
}
