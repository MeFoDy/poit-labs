<?php

class Statistic extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'report_id' => 'required',
		'ticket_id' => 'required',
	);

	public function tickets() {
		return $this->hasMany('Ticket');
	}

	public function summ() {
		$tickets = $this->hasMany('Ticket');
		$summ = 0;
		foreach ($tickets as $t) {
			$summ += $t->price;
		}
		return $summ;
	}
}
