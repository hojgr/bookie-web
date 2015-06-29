<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCsgoItemsNewItemMan extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('csgo_items', function(Blueprint $table)
		{
			$table->text("market_name")
				->after('name');

			$table->integer("csgo_item_quality_id")->unsigned()->after('id');
			$table->foreign("csgo_item_quality_id")->references("id")
				->on("csgo_item_qualities");

			$table->integer("csgo_item_exterior_id")->unsigned()->after('id');
			$table->foreign("csgo_item_exterior_id")->references("id")
				->on("csgo_item_exteriors");

			$table->boolean("stattrak")->after('blocked');
			$table->boolean("souvenir")->after('blocked');
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
