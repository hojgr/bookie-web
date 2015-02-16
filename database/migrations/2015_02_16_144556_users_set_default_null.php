<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersSetDefaultNull extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn(['display_name', 'avatar_path', 'steam_id', 'profile_name']);
        });

        Schema::table('users', function(Blueprint $table) {
            $table->string('steam_id')->after('id')->nullable();
            $table->string('display_name')->after('steam_id')->nullable();
            $table->string('profile_name')->after('display_name')->nullable();
            $table->string('avatar_path')->after('profile_name')->nullable();
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
