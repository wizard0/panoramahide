<div class="table-responsive table--no-card m-b-30">
    <table class="table table-borderless table-striped table-earning">
        <thead>
        <tr>
            @foreach($head as $name)
                <th>{{ __('admin.' . strtolower($name)) }}</th>
            @endforeach
            <th style="text-align: center">{{ __('admin.actions') }}</th>
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
                <td style="text-align: center">
                    <a href="{{ url()->current() }}/{{ $id }}/edit"><i class="far fa-edit"></i></a>
                    <a href="{{ url()->current() }}/{{ $id }}"><i class="fa fa-eye"></i></a>
                    <form action="{{ url()->current() }}/{{ $id }}" method="post" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="far fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
