<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organization_images', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer("image_type_id")->unsigned();
			$table->foreign("image_type_id")->references("id")
				->on("image_types");

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
		Schema::drop('organization_images');
	}

}
