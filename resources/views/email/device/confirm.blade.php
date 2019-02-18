@extends('email.layouts.app')

@section('content')
    <p>Подтвердите устройство {{ $oDevice->name }}.</p>
    <p>Код подтверждения <b>{{ $oDevice->code }}</b>.</p>
@endsection
