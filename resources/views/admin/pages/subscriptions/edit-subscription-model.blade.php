<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Edit') }} {{ __('Subscription') }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form action="{{ route('admin.subscriptions.update', $subscription->id) }}" id="form-edit-sub"
                        method="POST">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8">
                                <x-form.base-input type="text" name="start_date" label="{{ __('Start Date') }}"
                                    value="{{ $subscription->start_date }}" class="js-flatpickr" />
                                <x-form.base-input type="text" name="end_date" label="{{ __('End Date') }}"
                                    value="{{ $subscription->end_date }}" class="js-flatpickr" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-sm btn-primary" data-toggle="block-option"
                        data-action="state_toggle" data-action-mode="demo"
                        form="form-edit-sub">{{ __('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
