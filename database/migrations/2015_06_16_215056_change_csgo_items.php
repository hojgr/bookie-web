<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCsgoItems extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('csgo_items', function(Blueprint $table)
		{
			$table->dropColumn("name");
			$table->dropColumn("market_name");

		});
		Schema::table('csgo_items', function(Blueprint $table)
		{
			$table->string("market_name")->after("csgo_item_quality_id");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('csgo_items', function(Blueprint $table)
		{
			//
		});
	}

}
