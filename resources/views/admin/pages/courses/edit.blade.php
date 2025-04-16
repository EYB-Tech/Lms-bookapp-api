@extends('admin.layouts.app')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/raty-js/jquery.raty.css') }}">
@endsection
@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/plugins/raty-js/jquery.raty.js') }}"></script>
    <!-- Page JS Code -->
    @vite(['resources/js/pages/admin/media_selection.js', 'resources/js/pages/be_comp_rating.js'])
    <!-- Page JS Helpers (CKEditor 5 plugins) -->
    <script type="module">
        One.helpersOnLoad(['js-ckeditor5-classic']);
    </script>
@endsection
@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Courses'), 'url' => route('admin.courses.index')],
            ['label' => $course->name, 'url' => route('admin.courses.show', $course->id)],
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
        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('put') }}

            <!-- Info -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Info') }}</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <x-form.base-input type="text" name="name" label="{{ __('Name') }}"
                                value="{{ $course->name }}" />
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Info -->
        </form>
    </div>
    <!-- END Page Content -->
@endsection
