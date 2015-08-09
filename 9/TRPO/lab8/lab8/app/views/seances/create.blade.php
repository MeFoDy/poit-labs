@extends('layouts.scaffold')

@section('main')

<h1>Create Seance</h1>

{{ Form::open(array('route' => 'seances.store')) }}
	<ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('description', 'Description:') }}
            {{ Form::textarea('description') }}
        </li>

        <li>
            {{ Form::label('count', 'Count:') }}
            {{ Form::number('count') }}
        </li>

        <li>
            {{ Form::label('datetime', 'Datetime:') }}
            {{ Form::datetimelocal('datetime') }}
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


