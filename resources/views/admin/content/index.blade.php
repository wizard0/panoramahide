@extends('layouts.admin')

@section('content')

   	<div style="margin-top: -30px; margin-bottom: 10px;">
   	@php
   		$path = explode('/', Request::path());
   	@endphp
	@foreach ($path as $item)
		{{ __('admin.' . $item) }}
		@if (end($path) != $item)
			&nbsp;&nbsp;>&nbsp;&nbsp;
		@endif
    @endforeach
   	</div>

    <a class="btn btn-primary" style="margin-bottom: 20px" href="{{ route($slug . ".create")  }}">{{ __('Create a Record') }}</a>
    @component('components.admin.view_table', $data) @endcomponent

@endsection
