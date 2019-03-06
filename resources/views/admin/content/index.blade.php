@extends('layouts.admin')

@section('content')

    <a href="{{ route($slug . ".create")  }}">{{ __('Create a Record') }}</a>
    @component('components.admin.view_table', $data) @endcomponent

@endsection
