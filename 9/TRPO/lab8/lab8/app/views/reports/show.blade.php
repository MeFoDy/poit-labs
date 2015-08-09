@extends('layouts.scaffold')

@section('main')

<h1>Show Report</h1>

<p>{{ link_to_route('reports.index', 'Return to all reports') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
				<th>Date</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $report->name }}}</td>
					<td>{{{ $report->date }}}</td>
                    <td>{{ link_to_route('reports.edit', 'Edit', array($report->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('reports.destroy', $report->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
