@extends('personal.index')

@section('page-content')
    <div class="row justify-content-md-center">
        <div class="col-12 col-lg-8 col-lg-offset-2">
            @include('personal.login.form')
        </div>
    </div>
@endsection
