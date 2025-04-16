<div class="modal fade" id="import-students-modal" tabindex="-1" role="dialog" aria-labelledby="import-students-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Import') }} {{ __('Students') }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form action="{{ route('admin.students.import') }}" id="form-import-students" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8">
                                <div class="mb-4">
                                    <label class="form-label" for="excelFile">{{ __('Upload Excel File') }}:</label>
                                    <input type="file" id="excelFile" class="form-control" name="file"
                                        accept=".xls,.xlsx" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full text-end bg-body">
                    <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <a href="{{ route('admin.students.export-example') }}"
                        class="btn btn-sm btn-info">{{ __('Example Sheet') }}</a>
                    <button type="submit" class="btn btn-sm btn-primary" data-toggle="block-option"
                        data-action="state_toggle" data-action-mode="demo"
                        form="form-import-students">{{ __('Import') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
