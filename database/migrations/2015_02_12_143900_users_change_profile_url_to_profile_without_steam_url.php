<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use BookieGG\Models\User;

class UsersChangeProfileUrlToProfileWithoutSteamUrl extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->renameColumn("profile_url", "profile_name");
		});

		User::chunk(200, function($users) {
			foreach($users as $user) {
				if(!preg_match("-/id/([^\\^/]+)-", $user->profile_name, $matches))
					dd("Migration of user data was unsuccessful (profile_name -> {$user->profile_name}");
				$user->profile_name = $matches[1];
				$user->save();
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
