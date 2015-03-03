<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BetaSubscriptionsSetVarcharDefaultNull extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('beta_subscriptions', function(Blueprint $table) {
			$table->dropColumn(['name', 'email']);
		});

		Schema::table('beta_subscriptions', function(Blueprint $table) {
			$table->string("name")->after("id")->nullable();
			$table->string("email")->after("name")->nullable();

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
