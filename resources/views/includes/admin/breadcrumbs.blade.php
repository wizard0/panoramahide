<div style="margin-top: -30px; margin-bottom: 10px;">
@php
    $path = explode('/', Request::path());
@endphp

@foreach ($path as $item)
    @if (is_numeric($item))
        {{ 'ID:' . $item }}
    @else
        {{ __('admin.' . $item) }}
    @endif
    @if (end($path) != $item)
        &nbsp;&nbsp;>&nbsp;&nbsp;
    @endif
@endforeach
</div>
