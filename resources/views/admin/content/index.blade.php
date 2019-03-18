@extends('layouts.admin')

@section('content')

    @include('includes.admin.breadcrumbs')

    <a class="btn btn-primary" style="margin-bottom: 20px" href="{{ route($slug . ".create") }}">{{ __('Create a Record') }}</a>
    @component('components.admin.view_table', $data) @endcomponent

@endsection
