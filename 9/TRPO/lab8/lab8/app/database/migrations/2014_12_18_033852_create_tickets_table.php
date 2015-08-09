<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tickets', function (Blueprint $table) {
			$table->increments('id');
			$table->double('price');
			$table->integer('seance_id')->unsigned();
			$table->integer('row')->unsigned();
			$table->integer('place')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->boolean('status');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tickets');
	}

}
