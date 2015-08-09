<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('TicketsTableSeeder');
		$this->call('SeancesTableSeeder');
		$this->call('StatisticsTableSeeder');
		$this->call('ReportsTableSeeder');
	}

}
