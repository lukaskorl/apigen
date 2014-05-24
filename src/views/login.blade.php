@extends('apigen::layouts.master')

@section('head')
    <title>Login | {{ $title }}</title>
@stop

@section('body-class')login @stop

@section('body')
    {{ Form::open([ 'route' => 'admin_login_action', 'role' => 'form' ]) }}
        <div class="form-group">
            {{ Form::label('mail', 'E-Mail') }}
            {{ Form::email('mail', null, [ 'class' => 'form-control' ]) }}
        </div>
        <div class="form-group">
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password', [ 'class' => 'form-control' ]) }}
        </div>
        {{ Form::submit('Login', [ 'class' => 'btn btn-default' ]) }}
    {{ Form::close() }}
@stop

@section('scripts')
    $('body').colorful({ debug: true });
@stop