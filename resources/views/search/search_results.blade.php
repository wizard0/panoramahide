<div class="row col-xl-9 col-lg-9 col-12 order-3 order-xl-2 order-lg-2">
    @foreach($search as $s)
        @if ($params['type'] == 'journal')
            @component('components.journal_item', [
                'id' => $s->journalID,
                'image' => $s->journalImage,
                'name' => $s->journalName,
                'code' => $s->journalCode,
                'issn' => $s->journalISSN,
                'releases' => Release::where('journal_id', '=', $s->journalID)->withTranslation()->get(),
            ])
            @endcomponent
        @else
            @component('components.article_item', [
                'id' => $s->articleID,
                'author' => $s->authorName,
                'code' => $s->articleCode,
                'name' => $s->articleName,
                'journalCode' => $s->journalCode,
                'journalName' => $s->journalName,
                'releaseCode' => $s->releaseCode,
                'releaseID' => $s->releaseID,
                'releaseName' => $s->releaseName,
                'number' => $s->releaseNumber,
                'found' => $s->found,
                'length' => $s->length
            ])
            @endcomponent
        @endif
    @endforeach

    <div class="w-100 pagination d-flex justify-content-center">
        {{ $search->appends(app('request')->all())->links() }}
    </div>
</div>
