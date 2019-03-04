@extends('layouts.admin')

@section('pageTitle', ucfirst($slug))

@section('content')

    <a class="btn btn-primary" href="{{ route($slug. ".index") }}">{{ __('Back to List') }}</a>
    <br><br>
    <a class="btn btn-primary" href="{{ route($slug. ".edit", compact('id')) }}">{{ __('Edit Record') }}</a>
    <br>
    <div class="card">
        <div class="card-header">
            <strong>{{ ucfirst($slug) }}</strong> Elements
            <select id="translate_locale">
                @foreach(config('translatable.locales') as $locale)
                    <option value="{{ $locale }}" {{ ($locale == $translate_locale) ? 'selected' : '' }}>
                        {{ $locale }}</option>
                @endforeach
            </select>
        </div>
        <div class="card-body card-block">
                @foreach($data as $row)
                    @switch($row->type)
                        @case('text')
                        @case('price')
                        @case('string')
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label">{{ $row->name }}</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p class="form-control-static">{{ $row->value }}</p>
                                </div>
                            </div>
                        @break
                        @case('select')
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">{{ $row->name }}</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <select name="{{ $row->name }}"  class="form-control" disabled="disabled">
                                        @foreach($row->value as $value => $name)
                                            <option value="{{ $value }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @break
                        @case('image')
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="file-input" class=" form-control-label">{{ $row->name }}</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="file" name="{{ $row->name }}" value="{{ $row->value }}" class="form-control-file">
                                </div>
                            </div>
                            <div class="image-container"><img src="{{ $row->value }}"></div>
                        @break
                        @case('bool')
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label">{{ $row->name }}</label>
                                </div>
                                <div class="col col-md-9">
                                    <div class="form-check">
                                        <div class="radio">
                                            <label for="inline-radio1" class="form-check-label ">
                                                <input type="radio" name="{{ $row->name }}" value="0" class="form-check-input"
                                                        {{ ($row->value == 0) ? 'checked' : ''}}>Inactive
                                            </label></div>
                                        <div class="radio">
                                            <label for="inline-radio2" class="form-check-label ">
                                                <input type="radio" name="{{ $row->name }}" value="1" class="form-check-input"
                                                        {{ ($row->value == 1) ? 'checked' : '' }}>Active
                                            </label></div>
                                    </div>
                                </div>
                            </div>
                        @break
                        @case('relation-belongs-to')
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="select" class=" form-control-label">{{ __($row->name) }}</label>
                            </div>
                            <div class="col-12 col-md-9">
                                    @php
                                        $hasValues = array_key_exists('value', $row->value);
                                    @endphp
                                    @foreach($row->value['available'] as $available)
                                        @if($hasValues && $available['id'] == $row->value['value'])
                                            <a href="{{ route($row->value['slug'] . ".show", [$row->value['value']]) }}">{{ __($available['name']) }}</a>
                                        @endif
                                    @endforeach
                            </div>
                        </div>
                        @break
                        @case('relation-belongs-to-many')
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label>{{ $row->name }}</label>
                            </div>

                            <div class="col-12 col-md-9">
                                @php
                                    $hasValues = array_key_exists('value', $row->value);
                                @endphp
                                @foreach($row->value['available'] as $available)
                                    @if($hasValues && in_array($available['id'], $row->value['value']))
                                    <input type="checkbox" name="{{ $row->name }}[]" value="{{ $available['id'] }}"
                                            checked disabled>
                                        <a href="{{ route($row->value['slug'] . ".show", [$available['id']]) }}">{{ $available['name'] }}</a>
                                    <br>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @break
                    @endswitch
                @endforeach
        </div>
    </div>

@endsection
