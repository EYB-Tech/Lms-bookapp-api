@extends('admin.layouts.app')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection
@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Page JS Code -->
    <!-- Page JS Helpers (Summernote plugins) -->
    <script type="module">
        One.helpersOnLoad(['jq-select2', 'js-flatpickr', 'jq-datepicker']);
    </script>
@endsection
@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Courses'), 'url' => route('admin.subscriptions.index')],
            ['label' => __('Create')],
        ],
    ])
        @slot('title')
            {{ __('Create') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">

        <!-- Info -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Info') }}</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.subscriptions.store') }}" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <x-form.base-input type="text" name="start_date" label="{{ __('Start Date') }}"
                                class="js-flatpickr" placeholder="Y-m-d" value="{{ now() }}" />
                            <x-form.base-input type="text" name="end_date" label="{{ __('End Date') }}"
                                class="js-flatpickr" placeholder="Y-m-d" />
                            <div class="mb-4">
                                <label class="form-label" for="course">{{ __('Course') }}</label>
                                <select class="js-select2 form-select" name="course_id" style="width: 100%;"
                                    data-placeholder="Choose One..">
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="students">{{ __('Students') }}</label>
                                <select class="js-select2 form-select" name="students[]" style="width: 100%;"
                                    data-placeholder="Choose many.." multiple>
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}"
                                            {{ in_array($student->id, $importedStudents) ? 'selected' : '' }}>
                                            {{ $student->username ?? $student->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                data-action="state_toggle" data-action-mode="demo">{{ __('Create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Info -->
        <!-- Import -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Import') }}</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.subscriptions.import-students') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <x-form.base-input type="file" name="file" label="{{ __('Import Students') }}" />
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                data-action="state_toggle" data-action-mode="demo">{{ __('Import') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Import -->
    </div>
    <!-- END Page Content -->
@endsection
