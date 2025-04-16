<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-popout" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ __('Edit') }} {{ __('Language') }}</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            <form action="{{ route('admin.languages.update', ':id') }}" id="form-edit-lang"
                                method="POST">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-8">
                                        <div class="mb-4">
                                            <label class="form-label" for="edit-name">{{ __('Language') }}</label>
                                            <input type="hidden" name="name" id="edit-name">
                                            <select name="language_select" class="form-control">
                                                <option value="">{{ __('Select') }} {{ __('Language') }}</option>
                                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                    <option value="{{ $localeCode }}"
                                                        lang="{{ $properties['regional'] }}">{{ $properties['native'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="edit-direction">{{ __('Direction') }}</label>
                                            <select name="direction" class="form-control" id="edit-direction">
                                                <option value="ltr">{{ __('LTR') }}</option>
                                                <option value="rtl">{{ __('RTL') }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="edit-status">{{ __('Status') }}</label>
                                            <select name="status" id="edit-status" class="form-control">
                                                <option value="Publish">{{ __('Publish') }}</option>
                                                <option value="Draft">{{ __('Draft') }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="slug">{{ __('Slug') }}</label>
                                            <input type="text" class="form-control" readonly name="slug">
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
                                form="form-edit-lang">{{ __('Update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>