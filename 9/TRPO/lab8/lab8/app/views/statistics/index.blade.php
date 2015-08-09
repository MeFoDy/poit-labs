@extends('layouts.scaffold')

@section('main')

<h1>All Statistics</h1>

<p>{{ link_to_route('statistics.create', 'Add new statistic') }}</p>

@if ($statistics->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Report_id</th>
				<th>Ticket_id</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($statistics as $statistic)
				<tr>
					<td>{{{ $statistic->report_id }}}</td>
					<td>{{{ $statistic->ticket_id }}}</td>
                    <td>{{ link_to_route('statistics.edit', 'Edit', array($statistic->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('statistics.destroy', $statistic->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no statistics
@endif

@stop
