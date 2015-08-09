@extends('layouts.scaffold')

@section('main')

<h1>Create Ticket</h1>

<?php $seances = array(0 => 'Choose Seance');
foreach (Seance::get(array('id', 'name')) as $seance) {
	$seances[$seance->id] = $seance->name;
}?>
{{ Form::open(array('route' => 'tickets.store')) }}
	<ul>
        <li>
            {{ Form::label('price', 'Price:') }}
            {{ Form::text('price') }}
        </li>

        <li>
            {{ Form::label('seance_id', 'Seance:') }}
            {{ Form::select('seance_id', $seances) }}
        </li>

        <li>
            {{ Form::label('row', 'Row:') }}
            {{ Form::input('number', 'row') }}
        </li>

        <li>
            {{ Form::label('place', 'Place:') }}
            {{ Form::input('number', 'place') }}
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


