@extends('layouts.scaffold')

@section('main')

<h1>Edit Report</h1>
{{ Form::model($report, array('method' => 'PATCH', 'route' => array('reports.update', $report->id))) }}
	<ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('date', 'Date:') }}
            {{ Form::text('date') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('reports.show', 'Cancel', $report->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
