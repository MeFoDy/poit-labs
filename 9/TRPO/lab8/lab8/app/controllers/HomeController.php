<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	 */

	public function showWelcome() {
		$title = "Search";
		$seances = Seance::where('name', 'LIKE', '%')->get();
		return View::make('hello', compact('title', 'seances'));
	}

	public function search() {
		$name = Input::get('name');

		$seances = Seance::where('name', 'LIKE', '%' . $name . '%')->get();

		$title = "Seances: " . $seances->count;

		return View::make('hello', compact('seances', 'title'));
	}

	public function postSearch() {
		$q = Input::get('query');

		$seances = Seance::where('name', 'LIKE', '%' . $q . '%')->get();

		$title = "Seances: " . count($seances);

		return View::make('hello', compact('seances', 'title'));

	}

}
