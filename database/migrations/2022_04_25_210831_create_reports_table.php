<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('username', 20);
            $table->integer('edit_id');
            $table->string('good_or_comment', 10);
            $table->integer('can_report');
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
        Schema::table('reports', function (Blueprint $table) {
            //
            $table->dropColumn('id');
            $table->dropColumn('username', 20);
            $table->dropColumn('edit_id');
            $table->dropColumn('good_or_comment', 10);
            $table->dropColumn('can_report');
        });
    }
}
