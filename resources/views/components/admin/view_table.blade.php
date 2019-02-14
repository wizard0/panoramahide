<div class="table-responsive table--no-card m-b-30">
    <table class="table table-borderless table-striped table-earning">
        <thead>
        <tr>
            @foreach($head as $name)
                <th>{{ $name }}</th>
            @endforeach
            <th>{{ __('admin.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($body as $id => $row)
            <tr data-id="{{ $id }}">
                @foreach($row as $item)
                    @if (isset($item->html) && isset($item->html->class))
                        <td class="{{ $item->html->class }}">{{ $item->value }}</td>
                    @else
                        <td>{{ $item->value }}</td>
                    @endif
                @endforeach
                <td>
                    <a href="{{ url()->current() }}/{{ $id }}/edit">
                        <i class="far fa-edit"></i></a>
                    <a href="{{ url()->current() }}/{{ $id }}">
                        <i class="far fa-eye"></i></a>
                    <form action="{{ url()->current() }}/{{ $id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">
                            <i class="far fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
