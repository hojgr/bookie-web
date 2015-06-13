<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPrices extends Migration {

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

			$table->integer("csgo_item_id")->unsigned();
			$table->foreign("csgo_item_id")->references("id")
				->on("csgo_items");

			$table->float('price');
			$table->integer('volume');
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
		//
	}

}
