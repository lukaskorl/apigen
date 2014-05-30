@extends('apigen::layouts.master')

@section('head')
    <title>Login | {{ $title }}</title>
@stop

@section('body-class')login t-transparent @stop

@section('body')
    {{ Form::open([ 'route' => 'admin_login_action', 'role' => 'form', 'class' => 'l-centered-box' ]) }}
        <div class="form-group">
            {{ Form::label('email', 'Email Address') }}
            {{ Form::email('email', null, [ 'class' => 'form-control' ]) }}
        </div>
        <div class="form-group">
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password', [ 'class' => 'form-control' ]) }}
        </div>
        {{ Form::submit('>', [ 'class' => 'btn btn-default btn-next' ]) }}
    {{ Form::close() }}
@stop

@section('scripts')
    $('body').colorful({ debug: true });
@stop