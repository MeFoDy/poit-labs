<?php

class ReportsController extends BaseController {

	/**
	 * Report Repository
	 *
	 * @var Report
	 */
	protected $report;

	public function __construct(Report $report)
	{
		$this->report = $report;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$reports = $this->report->all();

		return View::make('reports.index', compact('reports'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('reports.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Report::$rules);

		if ($validation->passes())
		{
			$this->report->create($input);

			return Redirect::route('reports.index');
		}

		return Redirect::route('reports.create')
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
		$report = $this->report->findOrFail($id);

		return View::make('reports.show', compact('report'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$report = $this->report->find($id);

		if (is_null($report))
		{
			return Redirect::route('reports.index');
		}

		return View::make('reports.edit', compact('report'));
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
		$validation = Validator::make($input, Report::$rules);

		if ($validation->passes())
		{
			$report = $this->report->find($id);
			$report->update($input);

			return Redirect::route('reports.show', $id);
		}

		return Redirect::route('reports.edit', $id)
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
		$this->report->find($id)->delete();

		return Redirect::route('reports.index');
	}

}
