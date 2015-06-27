<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTradeWithdrawItemsChangeCsgoItemIdToUserBankId extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_trade_withdraw_items', function(Blueprint $table) {
            $table->dropForeign('user_trade_withdraw_items_csgo_item_id_foreign');
        });


        Schema::table('user_trade_withdraw_items', function(Blueprint $table) {
            $table->dropColumn('csgo_item_id');

            $table->integer("user_bank_id")->unsigned()->after('user_trade_id');
            $table->foreign("user_bank_id")->references("id")
                ->on("user_banks");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_trade_withdraw_items', function(Blueprint $table)
        {
            //
        });
    }

}
