<div class="reader-sidebar-chapter">
    <span>
        <a href="#article{{ sprintf("%02d", $oArticle->id) }}" data-scroll>{{ $oArticle->name }}</a>
        @if(!is_null($oArticle->description))
            <p>{{ $oArticle->description }}</p>
        @endif
    </span>
</div>
