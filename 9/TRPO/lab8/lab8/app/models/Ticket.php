<?php

class Ticket extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'price' => 'required|numeric|min:0',
		'seance_id' => 'required|exists:seances,id',
		'row' => 'required|numeric|min:1',
		'place' => 'required|numeric|min:1',
		'status' => 'boolean',
	);

	public function seance() {
		return $this->belongsTo('Seance');
	}

	public function user() {
		return $this->belongsTo('User');
	}
}
