@extends('layouts.scaffold')

@section('main')

<h1>Edit Statistic</h1>
{{ Form::model($statistic, array('method' => 'PATCH', 'route' => array('statistics.update', $statistic->id))) }}
	<ul>
        <li>
            {{ Form::label('report_id', 'Report_id:') }}
            {{ Form::text('report_id') }}
        </li>

        <li>
            {{ Form::label('ticket_id', 'Ticket_id:') }}
            {{ Form::text('ticket_id') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('statistics.show', 'Cancel', $statistic->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
