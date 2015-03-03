<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRemoveAkamaisUrlFromAvatarUrl extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->renameColumn('photo_url', 'avatar_path');
		});

		\BookieGG\Models\User::chunk(200, function($users) {
			foreach($users as $user) {
				$avatar_path = preg_replace('~^(.*)/avatars/~', '', $user->avatar_path);
				$user->avatar_path = $avatar_path;
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
		//
	}

}
