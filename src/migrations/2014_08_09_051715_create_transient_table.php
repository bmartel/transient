<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateTransientTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transients', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id', false, true);
            $table->string('model_type');
            $table->string('signature', 64);
            $table->string('property', 60);
            $table->string('value', 2000);
            $table->dateTime('expire');
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
        Schema::drop('transients');
    }

}
