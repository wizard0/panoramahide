@foreach (UserSearch::retrieve() as $id => $search)
    <div class="d-flex _saved_search"
         data-id="{{ $id }}"
         @foreach($search as $key=>$value)
            data-{{ $key }}="{{ $value }}"
         @endforeach
        >
        <button class="leftsharp _saved_search_delete" title="Удалить" data-id="{{ $id }}"><span></span></button>
        <div class="found-item">
            <span><a href="javascript:void(0);" class="black-link _saved_search_apply" data-id="{{ $id }}">
                    @if (isset($search->q))
                        {{ $search->q }}
                    @else
                        Сохранено {{ $search->created }}
                    @endif
                </a></span>
            @if (isset($search->journal))
                <p><span>журнал:</span>{{ Journal::getName($search->journal) }}</p>
            @endif
            @if ($search->type == UserSearch::TYPE_ARTICLE)
                <p><span>тип:</span>статьи</p>
            @elseif ($search->type == UserSearch::TYPE_JOURNAL)
                <p><span>тип:</span>журналы</p>
            @endif
        </div>
    </div>
@endforeach
