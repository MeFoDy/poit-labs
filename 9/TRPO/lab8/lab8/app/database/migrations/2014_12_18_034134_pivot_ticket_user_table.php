<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotTicketUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ticket_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ticket_user');
	}

}
