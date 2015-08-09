@extends('layouts.scaffold')

@section('main')

<h1>Show Statistic</h1>

<p>{{ link_to_route('statistics.index', 'Return to all statistics') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Report_id</th>
				<th>Ticket_id</th>
		</tr>
	</thead>

	<tbody>
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
	</tbody>
</table>

@stop
