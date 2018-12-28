<div class="row col-xl-9 col-lg-9 col-12 order-3 order-xl-2 order-lg-2">
    @foreach($search as $s)
        @if ($params['type'] == 'journal')
            @include('includes.journal_item', compact('s'))
        @else
            @include('includes.article_item', compact('s'))
        @endif
    @endforeach

    <div class="w-100 pagination d-flex justify-content-center">
        {{ $search->links() }}
    </div>
</div>
