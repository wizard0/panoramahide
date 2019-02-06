<div class="table-responsive table--no-card m-b-30">
    <table class="table table-borderless table-striped table-earning">
        <thead>
        <tr>
            @foreach($head as $name)
                <th>{{ $name }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($body as $row)
            <tr>
                @foreach($row as $item)
                    @if (isset($item->html) && isset($item->html->class))
                        <td class="{{ $item->html->class }}">{{ $item->value }}</td>
                    @else
                        <td>{{ $item->value }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
