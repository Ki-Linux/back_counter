<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit', function (Blueprint $table) {
            //
            $table->id();
            $table->string('username', 20);
            $table->string('picture', 200);
            $table->string('my_comment', 200);
            $table->boolean('can_good');
            $table->boolean('can_comment');
            $table->boolean('can_see');
            $table->boolean('can_top');
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
        Schema::table('edit', function (Blueprint $table) {
            //
            $table->id();
            $table->string('username', 20);
            $table->string('picture', 200);
            $table->string('my_comment', 200);
            $table->boolean('can_good');
            $table->boolean('can_comment');
            $table->boolean('can_see');
            $table->boolean('can_top');
            $table->timestamps();
        });
    }
}
