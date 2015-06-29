<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MatchTeamsCreate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('match_team', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer("match_id")->unsigned();
			$table->foreign("match_id")->references("id")->on("matches");

			$table->integer("team_id")->unsigned();
			$table->foreign("team_id")->references("id")->on("teams");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('match_teams');
	}

}
