<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transient', function(Blueprint $table){
            $table->increments('id');
            $table->integer('model_id', true);
            $table->string('model_type');
            $table->string('signature', 60);
            $table->string('property', 255);
            $table->string('value', 2000);
            $table->dateTime('expires');
            $table->timestamps();
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transient');
	}

}
