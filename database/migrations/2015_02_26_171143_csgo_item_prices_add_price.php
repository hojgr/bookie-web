<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CsgoItemPricesAddPrice extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('csgo_item_prices', function(Blueprint $table)
		{
			$table->float('price')->after("csgo_item_exterior_id");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('csgo_item_prices', function(Blueprint $table)
		{
			//
		});
	}

}
