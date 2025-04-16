<div class="modal fade" id="add-word-modal" tabindex="-1" role="dialog" aria-labelledby="add-word-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Add') }} {{ __('Word') }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form action="{{ route('admin.languages.add-new-words') }}" id="form-add-word"
                        method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8">
                                <div class="mb-4">
                                    <label class="form-label" for="title">{{ __('Language') }}</label>
                                    <select name="lang_slug" class="form-control">
                                        <option value="">{{ __('Select') }} {{ __('Language') }}</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->slug }}">
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="new_string">{{ __('New String') }}</label>
                                    <input type="text" id="new_string" class="form-control" name="new_string"
                                        required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label"
                                        for="translate_string">{{ __('Translate String') }}</label>
                                    <input type="text" id="translate_string" class="form-control"
                                        name="translate_string" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-sm btn-primary" data-toggle="block-option"
                        data-action="state_toggle" data-action-mode="demo"
                        form="form-add-word">{{ __('Create') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
