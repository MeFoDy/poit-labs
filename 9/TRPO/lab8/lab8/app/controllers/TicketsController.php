<?php

class TicketsController extends BaseController {

	/**
	 * Ticket Repository
	 *
	 * @var Ticket
	 */
	protected $ticket;

	public function __construct(Ticket $ticket)
	{
		$this->ticket = $ticket;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tickets = $this->ticket->all();

		return View::make('tickets.index', compact('tickets'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('tickets.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Ticket::$rules);

		if ($validation->passes())
		{
			$this->ticket->create($input);

			return Redirect::route('tickets.index');
		}

		return Redirect::route('tickets.create')
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
		$ticket = $this->ticket->findOrFail($id);

		return View::make('tickets.show', compact('ticket'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ticket = $this->ticket->find($id);

		if (is_null($ticket))
		{
			return Redirect::route('tickets.index');
		}

		return View::make('tickets.edit', compact('ticket'));
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
		$validation = Validator::make($input, Ticket::$rules);

		if ($validation->passes())
		{
			$ticket = $this->ticket->find($id);
			$ticket->update($input);

			return Redirect::route('tickets.show', $id);
		}

		return Redirect::route('tickets.edit', $id)
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
		$this->ticket->find($id)->delete();

		return Redirect::route('tickets.index');
	}

}
