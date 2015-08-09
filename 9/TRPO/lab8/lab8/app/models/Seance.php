<?php

class Seance extends Eloquent {
	protected $table = 'seances';

	protected $guarded = array();

	public static $rules = array(
		'name' => 'required|min:2|max:200',
		'description' => 'required|min:2',
		'count' => 'required|numeric|min:1',
		'datetime' => 'required|date',
	);

	public function tickets() {
		return $this->hasMany('Ticket');
	}
}
