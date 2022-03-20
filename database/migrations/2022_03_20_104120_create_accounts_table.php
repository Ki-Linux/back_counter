<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 20);
            $table->string('icon', 100);
            $table->string('comment', 200);
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
        Schema::table('accounts', function (Blueprint $table) {
            //
            $table->dropColumn('id');
            $table->dropColumn('username', 20);
            $table->dropColumn('icon', 100);
            $table->dropColumn('comment', 200);
            $table->dropColumn('timestamps');
        });
    }
}
