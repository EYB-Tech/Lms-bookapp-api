<input type="hidden" name="{{ $input }}" id="{{ $id ?? $input }}" value="{{$value ?? ''}}">
<button class="btn btn-alt-secondary btn-select-upload-file" data-file-type="image" data-selection-type="{{ $type }}"
    data-input-set-value="#{{ $id ?? $input }}" type="button" data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasScrollingBackdrop" aria-controls="offcanvasScrollingBackdrop">
    <i class="fa fa-fw fa-image me-1"></i>
    {{ $title }}
</button>
