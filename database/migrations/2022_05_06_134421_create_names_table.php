<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('half_access_names', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('account_id');
            $table->string('front', 200);
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
        Schema::create('half_access_names', function (Blueprint $table) {
            //
            $table->dropColumn('account_id');
            $table->dropColumn('front');
        });
    }
}
