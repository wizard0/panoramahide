@extends('layouts.admin')

@section('content')
    <a class="btn btn-primary" href="{{ route($slug . ".show", compact('id')) }}">{{ __('Back to View') }}</a>
    <br><br>
    <a class="btn btn-primary" href="{{ route($slug . ".index") }}">{{ __('Back to List') }}</a>
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body card-block">
            <form action="{{ substr(url()->current(), 0, stripos(url()->current(), '/edit')) }}"
                  method="POST" enctype="multipart/form-data" class="form-horizontal"
                  id="edit-form" name="edit-form">
                <input name="_method" type="hidden" value="PUT">
                <input type="hidden" name="translate_locale" value="{{ $translate_locale }}">
                @csrf
    @foreach($data as $row)
        @switch($row->type)
            @case('price')
            @case('string')
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ $row->name }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="{{ $row->name }}" class="form-control" value="{{ $row->value }}">
                            <small class="form-text text-muted">This is a help text</small>
                        </div>
                    </div>
                @break
            @case('text')
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="textarea-input" class=" form-control-label">{{ $row->name }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea name="{{ $row->name }}" rows="9" class="form-control">{{ $row->value }}</textarea>
                        </div>
                    </div>
                @break
            @case('select')
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="select" class=" form-control-label">{{ __($row->name) }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select name="{{ $row->name }}"  class="form-control">
                                @foreach($row->value as $value => $name)
                                    <option value="{{ $value }}">{{ __($name) }}</option>
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
                            <select name="{{ $row->name }}"  class="form-control">
                                @php
                                    $hasValues = array_key_exists('value', $row->value);
                                @endphp
                                    <option value="">{{ __('Nothing choosed') }}</option>
                                @foreach($row->value['available'] as $available)
                                    <option value="{{ $available['id'] }}"
                                    {{ ($hasValues && $available['id'] == $row->value['value'])  ? 'selected' : '' }}>
                                        {{ __($available['name']) }}</option>
                                @endforeach
                            </select>
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
                        @if(isset($row->value['available']))
                            @foreach($row->value['available'] as $available)
                                <input type="checkbox" name="{{ $row->name }}[]" value="{{ $available['id'] }}"
                                        {{ ($hasValues && in_array($available['id'], $row->value['value'])) ? 'checked' : '' }}>
                                {{ $available['name'] }}
                                <br>
                            @endforeach
                        @endif
                    </div>
                </div>
                @break
        @endswitch
    @endforeach

            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm" onclick="javascript:document.forms['edit-form'].submit()">
                <i class="fa fa-dot-circle-o"></i> Submit
            </button>
            {{--<button type="reset" class="btn btn-danger btn-sm">--}}
                {{--<i class="fa fa-ban"></i> Reset--}}
            {{--</button>--}}
        </div>
    </div>
@endsection
