<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_images', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('filename');

			$table->integer("team_id")->unsigned();
			$table->foreign("team_id")->references("id")
				->on("teams");

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
		Schema::drop('team_images');
	}

}
