<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTradesAddNewFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_trades', function(Blueprint $table)
		{
            $table->integer("bot_id")->nullable()->unsigned()->after('redis_trade_id');
            $table->foreign("bot_id")->references("id")
                ->on("bots");

            $table->datetime('trade_created_at');

            
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_trades', function(Blueprint $table)
		{
			//
		});
	}

}
