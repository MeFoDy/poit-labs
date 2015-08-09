<?php

class SeancesController extends BaseController {

	/**
	 * Seance Repository
	 *
	 * @var Seance
	 */
	protected $seance;

	public function __construct(Seance $seance)
	{
		$this->seance = $seance;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$seances = $this->seance->all();

		return View::make('seances.index', compact('seances'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('seances.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Seance::$rules);

		if ($validation->passes())
		{
			$this->seance->create($input);

			return Redirect::route('seances.index');
		}

		return Redirect::route('seances.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$seance = $this->seance->findOrFail($id);

		return View::make('seances.show', compact('seance'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$seance = $this->seance->find($id);

		if (is_null($seance))
		{
			return Redirect::route('seances.index');
		}

		return View::make('seances.edit', compact('seance'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Seance::$rules);

		if ($validation->passes())
		{
			$seance = $this->seance->find($id);
			$seance->update($input);

			return Redirect::route('seances.show', $id);
		}

		return Redirect::route('seances.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->seance->find($id)->delete();

		return Redirect::route('seances.index');
	}

}
