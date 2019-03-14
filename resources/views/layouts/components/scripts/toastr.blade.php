@if(Session::has('toastr::notifications'))
    {!! Toastr::render() !!}
@else
    <script>
        window.toastrOptions = {!! json_encode(config('toastr.options')) !!};
    </script>
@endif
