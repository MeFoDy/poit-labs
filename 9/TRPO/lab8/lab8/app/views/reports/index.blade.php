@extends('layouts.scaffold')

@section('main')

<h1>All Reports</h1>

<p>{{ link_to_route('reports.create', 'Add new report') }}</p>

@if ($reports->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Date</th>
				<th>Count</th>
				<th>Price</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($reports as $report)
				<tr>
					<td>{{ link_to_route('reports.show', $report->name, array($report->id), array('class' => '')) }}</td>
					<td>{{{ $report->date }}}</td>
					<td>{{{ $report->seancesCount() }}}</td>
					<td>{{{ $report->seancesPrice() }}}</td>
                    <td>{{ link_to_route('reports.edit', 'Edit', array($report->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('reports.destroy', $report->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no reports
@endif

@stop
