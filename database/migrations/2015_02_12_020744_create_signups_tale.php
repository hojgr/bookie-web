<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignupsTale extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sign_ups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("user_id")->unsigned();
			$table->foreign("user_id")->references("id")->on("users");
			$table->string("name");
			$table->string("email");
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
		Schema::drop('sign_ups');
	}

}
