<form action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="hidden" name="lang[login_page_content]" value="{{ $lang }}">
    <input type="hidden" name="login_page_content" value="">
    <div class="row">
        <div class="col-12">
            <x-form.floating-textarea type="text" name="login_page_content" label="{{ __('Details') }}"
                placeholder="{{ __('Details') }}" value="{{ get_setting('login_page_content', null, $lang) }}" />
        </div>
        <div class="col-12">
            <div class="mb-4">
                <x-form.btn-select-image type="single" input="login_page_image" title="{{ __('Image') }}"
                    value="{{ old('login_page_image', get_setting('login_page_image')) }}" />
                <div class="mt-2">
                    <img class="img-avatar" src="{{ uploaded_asset(get_setting('login_page_image')) }}" alt="Login Image">
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <button type="submit" class="btn btn-alt-primary" data-toggle="block-option" data-action="state_toggle"
            data-action-mode="demo">{{ __('Update') }}</button>
    </div>
</form>
