<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotStatisticTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statistic_ticket', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('statistic_id')->unsigned()->index();
			$table->integer('ticket_id')->unsigned()->index();
			$table->foreign('statistic_id')->references('id')->on('statistics')->onDelete('cascade');
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
		Schema::drop('statistic_ticket');
	}

}
