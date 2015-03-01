<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrganizationImagesAddFilename extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('organization_images', function(Blueprint $table)
		{
			$table->string('filename')->after('image_type_id');


			$table->integer("organization_id")->unsigned()->after('filename');
			$table->foreign("organization_id")->references("id")
				->on("organizations");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('organization_images', function(Blueprint $table)
		{
			//
		});
	}

}
