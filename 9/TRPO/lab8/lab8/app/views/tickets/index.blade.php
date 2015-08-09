@extends('layouts.scaffold')

@section('main')

<h1>All Tickets</h1>

<p>{{ link_to_route('tickets.create', 'Add new ticket') }}</p>

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
			@foreach ($tickets as $ticket)
				<tr>
					<td>{{{ $ticket->price }}}</td>
					<td>{{{ $ticket->seance['name'] }}}</td>
					<td>{{{ $ticket->row }}}</td>
					<td>{{{ $ticket->place }}}</td>
					<td>{{{ ($ticket->status) ? "selled" : "free"  }}}</td>
					<td>{{{ $ticket->user['username'] }}}</td>
                    <td>{{ link_to_route('tickets.edit', 'Edit', array($ticket->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('tickets.destroy', $ticket->id))) }}
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
