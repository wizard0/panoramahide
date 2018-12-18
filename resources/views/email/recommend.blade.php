Пользователь {{ $emailFrom }} рекомендует Вам посмотреть эти страницы:<br>
@foreach($links as $link)
    {{ $link }} <br>
@endforeach
