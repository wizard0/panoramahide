@extends('personal.index')

@section('page-content')
    <div class="row justify-content-md-center">
        <div class="col-12 col-lg-8 col-lg-offset-2">
            @if (session('status'))
                <div class="alert alert-success" role="alert" style="margin-top: 1rem;">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label>Укажите ваш Email</label>
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">
                        Отправить ссылку для восстановления пароля
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
