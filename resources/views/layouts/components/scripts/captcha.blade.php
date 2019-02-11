@if(Auth::guest())
    {!!  GoogleReCaptchaV3::render([
       'auth_register_id' => 'auth/register'
    ]) !!}
@endif
