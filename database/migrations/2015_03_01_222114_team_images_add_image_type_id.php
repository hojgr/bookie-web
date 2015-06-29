<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TeamImagesAddImageTypeId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('team_images', function(Blueprint $table)
		{
			$table->integer("image_type_id")->unsigned();
			$table->foreign("image_type_id")->references("id")
				->on("image_types");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('team_images', function(Blueprint $table)
		{
			//
		});
	}

}
