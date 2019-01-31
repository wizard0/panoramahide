<div class="cover-label">
    <label class="journal-checkbox">
        <input type="checkbox" value="{{ $oItem['id'] }}" name="journals[]" {{ isset($checked) && $checked ? 'checked="checked"' : '' }}>
        <span>
            <img src="{{ isset($img) ? url('img/covers/'.$img) :  url('img/covers/cover04.jpg') }}">
            <span class="innerspan"></span>
        </span>
    </label>
</div>
