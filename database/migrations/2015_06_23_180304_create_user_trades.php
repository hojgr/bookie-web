<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTrades extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('user_trades', function(Blueprint $table) {
            $table->increments('id');
            
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references("id")
                ->on("users");

            $table->string("type"); // 

            $table->string('status');

            $table->timestamps();
        });

        Schema::create('user_trade_deposit_items', function(Blueprint $table) {
            $table->increments('id');
            
            $table->integer("user_trade_id")->unsigned();
            $table->foreign("user_trade_id")->references("id")
                ->on("user_trades");

            $table->string('steam_item_id');
            $table->string('class_id');
            $table->string('instance_id');


            $table->timestamps();

        });

        Schema::create('user_trade_withdraw_items', function(Blueprint $table) {
            $table->increments('id');
            
            $table->integer("user_trade_id")->unsigned();
            $table->foreign("user_trade_id")->references("id")
                ->on("user_trades");

            $table->integer("csgo_item_id")->unsigned();
            $table->foreign("csgo_item_id")->references("id")
                ->on("csgo_items");

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
        Schema::drop('user_trades');
    }

}
