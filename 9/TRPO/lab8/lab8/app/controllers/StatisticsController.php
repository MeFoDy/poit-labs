<?php

class StatisticsController extends BaseController {

	/**
	 * Statistic Repository
	 *
	 * @var Statistic
	 */
	protected $statistic;

	public function __construct(Statistic $statistic)
	{
		$this->statistic = $statistic;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$statistics = $this->statistic->all();

		return View::make('statistics.index', compact('statistics'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('statistics.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Statistic::$rules);

		if ($validation->passes())
		{
			$this->statistic->create($input);

			return Redirect::route('statistics.index');
		}

		return Redirect::route('statistics.create')
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
		$statistic = $this->statistic->findOrFail($id);

		return View::make('statistics.show', compact('statistic'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$statistic = $this->statistic->find($id);

		if (is_null($statistic))
		{
			return Redirect::route('statistics.index');
		}

		return View::make('statistics.edit', compact('statistic'));
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
		$validation = Validator::make($input, Statistic::$rules);

		if ($validation->passes())
		{
			$statistic = $this->statistic->find($id);
			$statistic->update($input);

			return Redirect::route('statistics.show', $id);
		}

		return Redirect::route('statistics.edit', $id)
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
		$this->statistic->find($id)->delete();

		return Redirect::route('statistics.index');
	}

}
