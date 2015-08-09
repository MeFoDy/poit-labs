<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotSeanceTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seance_ticket', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('seance_id')->unsigned()->index();
			$table->integer('ticket_id')->unsigned()->index();
			$table->foreign('seance_id')->references('id')->on('seances')->onDelete('cascade');
			$table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('seance_ticket');
	}

}
