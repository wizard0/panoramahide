<div class="cover-label">
    <label class="journal-checkbox"
        data-tippy-popover
        data-tippy-content='{{ bladeHelper()->popover($oItem) }}'
    >
        <input type="checkbox" value="{{ $oItem['id'] }}::{{ $promocode_id }}" name="journal::promocode[]" {{ isset($checked) && $checked ? 'checked="checked"' : '' }}>
        <span>
            <img src="{{ isset($img) ? url('img/covers/'.$img) :  url('img/covers/cover04.jpg') }}">
            @if(isset($innerspan) && !$innerspan)

            @else
                <span class="innerspan"></span>
            @endif
        </span>
    </label>
</div>
