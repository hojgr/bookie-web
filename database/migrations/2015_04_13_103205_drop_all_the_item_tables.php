<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAllTheItemTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop("user_banks");
		Schema::drop("csgo_item_prices");
		Schema::drop("csgo_item_exteriors");
		Schema::drop("csgo_item_skins");
		Schema::drop("csgo_items");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
