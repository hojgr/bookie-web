<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBank extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_banks', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer("user_id")->unsigned();
			$table->foreign("user_id")->references("id")
				->on("users");

			$table->integer("csgo_item_id")->unsigned();
			$table->foreign("csgo_item_id")->references("id")
				->on("csgo_items");

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
		Schema::drop('user_banks');
	}

}
