@extends('layouts.scaffold')

@section('main')

<h1>Edit Seance</h1>
{{ Form::model($seance, array('method' => 'PATCH', 'route' => array('seances.update', $seance->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('seances.show', 'Cancel', $seance->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
