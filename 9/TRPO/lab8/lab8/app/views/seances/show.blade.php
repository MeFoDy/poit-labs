@extends('layouts.scaffold')

@section('main')

<h1>Show Seance</h1>

<p>{{ link_to_route('seances.index', 'Return to all seances') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
				<th>Description</th>
				<th>Count</th>
				<th>Datetime</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $seance->name }}}</td>
					<td>{{{ $seance->description }}}</td>
					<td>{{{ $seance->count }}}</td>
					<td>{{{ $seance->datetime }}}</td>
                    <td>{{ link_to_route('seances.edit', 'Edit', array($seance->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('seances.destroy', $seance->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

<h4>Available Tickets</h4>
<?php $tickets = $seance->tickets();?>
<?php $tickets = Ticket::where('seance_id', '=', $seance->id)->get();?>
@if ($tickets->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Price</th>
				<th>Seance</th>
				<th>Row</th>
				<th>Place</th>
				<th>Status</th>
				<th>User</th>
			</tr>
		</thead>

		<tbody>
@foreach ($tickets as $t)
				<tr>
					<td>{{{ $t->price }}}</td>
					<td>{{{ $t->seance['name'] }}}</td>
					<td>{{{ $t->row }}}</td>
					<td>{{{ $t->place }}}</td>
					<td>{{{ ($t->status) ? "selled" : "free"  }}}</td>
					<td>{{{ $t->user['username'] }}}</td>
                    <td>{{ link_to_route('tickets.edit', 'Edit', array($t->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('tickets.destroy', $t->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no tickets
@endif

@stop
