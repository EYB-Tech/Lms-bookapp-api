@extends('admin.layouts.app')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection
@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Page JS Code -->
    @vite(['resources/js/pages/admin/media_selection.js', 'resources/js/pages/admin/select_lesson_type.js'])
    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script type="module">
        One.helpersOnLoad(['js-ckeditor5-classic', 'jq-select2']);
    </script>
@endsection
@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Courses'), 'url' => route('admin.courses.index')],
            ['label' => $lesson->course->name, 'url' => route('admin.courses.show', $lesson->course->id)],
            ['label' => $lesson->name, 'url' => route('admin.lessons.show', $lesson->id)],
            ['label' => __('Edit')],
        ],
    ])
        @slot('title')
            {{ __('Edit') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST" id="lesson-form"
            data-id="{{ $lesson->id }}" data-url="{{ route('admin.lessons.content') }}">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <input type="hidden" name="type" value="file">
            <!-- Info -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Info') }}</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-form.base-input type="text" name="name" label="{{ __('Name') }}"
                                        value="{{ $lesson->name }}" />
                                </div>
                                <div class="col-lg-6">
                                    <x-form.base-input type="text" name="order" label="{{ __('Sort Order') }}"
                                        value="{{ $lesson->order }}" />
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label class="form-label" for="tags">{{ __('Tags') }}</label>
                                        <select class="js-select2 form-select" name="tags[]" style="width: 100%;"
                                            data-placeholder="Choose many.." multiple>
                                            <option></option>
                                            <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}" @selected(in_array($tag->id, $lesson->tags->pluck('id')->toArray() ?? []))>
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <input type="hidden" id="file-id" name="attached_id"
                                            value="{{ old('attached_id', $lesson?->attached_id) }}">
                                        <button class="btn btn-alt-secondary btn-select-upload-file"
                                            data-selection-type="single" data-file-type="application"
                                            data-input-set-value="#file-id" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasScrollingBackdrop"
                                            aria-controls="offcanvasScrollingBackdrop">
                                            <i class="fa fa-fw fa-image me-1"></i>
                                            {{ __('Select File') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label">{{ __('Published') }}?</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" value="" id="active"
                                                name="active" @checked($lesson->active)>
                                            <label class="form-check-label" for="active"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                data-action="state_toggle" data-action-mode="demo">{{ __('Update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Info -->
        </form>
    </div>
    <!-- END Page Content -->
@endsection
