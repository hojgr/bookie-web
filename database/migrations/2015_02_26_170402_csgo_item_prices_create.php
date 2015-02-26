<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CsgoItemPricesCreate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('csgo_item_prices', function(Blueprint $table)
		{
			$table->increments('id');


			$table->integer("csgo_item_skin_id")->unsigned();
			$table->foreign("csgo_item_skin_id")->references("id")
				->on("csgo_item_skins");

			$table->integer("csgo_item_exterior_id")->unsigned();
			$table->foreign("csgo_item_exterior_id")->references("id")
				->on("csgo_item_exteriors");


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
		Schema::drop('csgo_item_prices');
	}

}
