<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotReportStatisticTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('report_statistic', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('report_id')->unsigned()->index();
			$table->integer('statistic_id')->unsigned()->index();
			$table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
			$table->foreign('statistic_id')->references('id')->on('statistics')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('report_statistic');
	}

}
