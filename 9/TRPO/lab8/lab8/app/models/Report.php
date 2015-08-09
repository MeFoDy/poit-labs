<?php

class Report extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'date' => 'required',
	);

	public function statistics() {
		return $this->hasMany('Statistic');
	}

	public function seancesCount() {
		$res = DB::select('select count(*) as c from statistics as st inner join tickets as t on st.ticket_id = t.id where report_id = ?', array($this->id));
		return $res[0]->c;
	}

	public function seancesPrice() {
		$res = DB::select('select sum(price) as c from statistics as st inner join tickets as t on st.ticket_id = t.id where report_id = ?', array($this->id));
		return $res[0]->c;
	}

}
