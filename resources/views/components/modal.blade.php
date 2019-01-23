<div class="modal fade {{ isset($in) && $in ? 'show' : '' }}" id="{{ $id }}" style="{{ isset($in) && $in ? 'display: block' : '' }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @if(!isset($header) || $header)
                <div class="modal-header">
                    <h4 class="modal-title">{{ $title }}</h4>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
            @endif
            <div class="modal-body">
                @if(isset($closeBody) && $closeBody)
                    <a href="#" class="close __close-body" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                @endif
                {{ $body }}
            </div>
        </div>
    </div>
</div>
