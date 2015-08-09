@extends('layouts.scaffold')

@section('main')

<h1>Edit Ticket</h1>
<?php $users = array(0 => 'Choose User');
foreach (User::get(array('id', 'username')) as $user) {
	$users[$user->id] = $user->username;
}?>

<?php $seances = array(0 => 'Choose Seance');
foreach (Seance::get(array('id', 'name')) as $seance) {
	$seances[$seance->id] = $seance->name;
}?>
{{ Form::model($ticket, array('method' => 'PATCH', 'route' => array('tickets.update', $ticket->id))) }}
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
            {{ Form::label('status', 'Status:') }}
            {{ Form::radio('status', 1, $ticket->status ? true : false) }} Selled
            {{ Form::radio('status', 0, $ticket->status ? false : true) }} Free
        </li>

        <li>
            {{ Form::label('user_id', 'User:') }}
            {{ Form::select('user_id', $users) }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('tickets.show', 'Cancel', $ticket->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
