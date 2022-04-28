<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('username', 20);
            $table->integer('edit_id');
            $table->integer('views');
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
        Schema::table('views', function (Blueprint $table) {
            //
            $table->dropColumn('id');
            $table->dropColumn('username', 20);
            $table->dropColumn('edit_id');
            $table->dropColumn('views');
        });
    }
}
