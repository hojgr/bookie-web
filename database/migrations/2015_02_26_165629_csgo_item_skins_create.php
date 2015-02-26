<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CsgoItemSkinsCreate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('csgo_item_skins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('');

			$table->integer("csgo_item_id")->unsigned();
			$table->foreign("csgo_item_id")->references("id")->on("csgo_items");

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
		Schema::drop('csgo_item_skins');
	}

}
