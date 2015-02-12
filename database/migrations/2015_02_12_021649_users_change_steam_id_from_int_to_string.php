<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersChangeSteamIdFromIntToString extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('steam_id');
		});

		Schema::table('users', function(Blueprint $table)
		{
			$table->string("steam_id"); // int is not big enough for steam id... obviously
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn("steam_id");
		});

		Schema::table('users', function(Blueprint $table)
		{
			$table->integer("steam_id");
		});
	}

}
