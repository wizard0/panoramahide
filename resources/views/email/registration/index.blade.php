@extends('email.layouts.app')

@section('content')
    <p style="text-align: center"><b>Ваш логин:</b> {{ $email }}</p>
    <p style="text-align: center"><b>Ваш пароль:</b> {{ $password }}</p>
@endsection
