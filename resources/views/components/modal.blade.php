<div class="modal fade {{ isset($in) && $in ? 'show' : '' }}" id="{{ $id }}" style="{{ isset($in) && $in ? 'display: block' : '' }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
        </div>
    </div>
</div>
