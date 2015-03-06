<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('match_notes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('match_id')->unsigned();
			$table->foreign('match_id')->references('id')->on('matches');
			$table->string('note', 60);
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
		Schema::drop('match_notes');
	}

}
