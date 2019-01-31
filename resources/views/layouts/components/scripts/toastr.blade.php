@if(Session::has('toastr::notifications'))
    {!! Toastr::render() !!}
@else
    <script>
        toastr.options = {!! json_encode(config('toastr.options')) !!};
    </script>
@endif
