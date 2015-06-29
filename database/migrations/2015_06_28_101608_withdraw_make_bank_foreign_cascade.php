<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WithdrawMakeBankForeignCascade extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table(
            'user_trade_withdraw_items',
            function (Blueprint $table) {
                $table->dropForeign(
                    'user_trade_withdraw_items_user_bank_id_foreign'
                );
            }
        );
        Schema::table(
            'user_trade_withdraw_items',
            function (Blueprint $table) {
                $table->foreign('user_bank_id')
                    ->references('id')->on('user_banks')
                    ->onDelete('cascade');
            }
        );
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
