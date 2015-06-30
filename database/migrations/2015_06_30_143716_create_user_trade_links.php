<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTradeLinks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_trade_links', function(Blueprint $table)
		{
			$table->increments('id');

            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references("id")
                ->on("users");

            $table->integer("partner");
            $table->string("token");

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
		Schema::drop('user_trade_links');
	}

}
