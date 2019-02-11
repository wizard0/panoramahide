<div class="reader-sidebar-journal d-flex align-items-center flex-column">
    <a href="{{ url('/reader?release_id='.$oRelease->id) }}">
        <img src="{{ $oRelease->image }}" class="mCS_img_loaded">
    </a>
    <a href="{{ url('/reader?release_id='.$oRelease->id) }}" class="text-center red-link __j-on-hover m-t-10">
        <b>№{{ $oRelease->number }}/{{ $oRelease->year }}</b>
    </a>
</div>
