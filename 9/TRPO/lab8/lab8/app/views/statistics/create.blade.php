@extends('layouts.scaffold')

@section('main')

<h1>Create Statistic</h1>

{{ Form::open(array('route' => 'statistics.store')) }}
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
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


