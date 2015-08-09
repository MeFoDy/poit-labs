@extends('layouts.scaffold')

@section('main')

<h1>Login</h1>

<p>{{ link_to_route('login.register', 'Register') }}</p>

{{ Form::open(array('route' => 'login.index')) }}
    <ul>
        <li>
            {{ Form::label('email', 'Email or Username:') }}
            {{ Form::text('email') }}
        </li>

        <li>
            {{ Form::label('password', 'Password:') }}
            {{ Form::password('password') }}
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
