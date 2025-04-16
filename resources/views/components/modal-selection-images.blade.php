<!-- Offcanvas Right -->
<div class="offcanvas offcanvas-end bg-body-extra-light" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1"
    id="offcanvasScrollingBackdrop" aria-labelledby="offcanvasScrollingBackdropLabel">
    <div class="offcanvas-header bg-body-light">
        <h5 class="offcanvas-title" id="offcanvasScrollingBackdropLabel"> <button type="button"
                class="btn btn-alt-primary" id="save-selection">{{ __('Save Selection') }}</button></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row g-3" id="model-media-container" data-url="{{ route('admin.fetch-uploads') }}"
            data-asset="{{ asset('') }}">

        </div>
    </div>
</div>
<!-- END Offcanvas Right -->
