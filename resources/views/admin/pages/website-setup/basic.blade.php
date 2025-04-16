@extends('admin.layouts.app')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/simplemde/simplemde.min.css') }}">
@endsection
@section('js')
    <!-- Page JS Plugins -->
    @vite(['resources/js/pages/admin/media_selection.js'])
    {{-- <script src="{{ asset('js/plugins/simplemde/simplemde.min.js') }}"></script> --}}

    {{-- <!-- Page JS Helpers (SimpleMDE plugins) -->
    <script type="module">
        One.helpersOnLoad(['js-simplemde']);
    </script> --}}
@endsection
@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Basic Settings')],
        ],
    ])
        @slot('title')
            {{ __('Basic Settings') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <!-- Basic -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Basic') }}</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <x-form.base-input type="text" name="site_title" label="{{ __('Website Name') }}"
                                value="{{ env('APP_NAME', 'Laravel') }}" />
                            <div class="mb-4">
                                <label class="form-label" for="site_description">{{ __('Website Description') }}</label>
                                <textarea class="form-control" id="site_description" name="site_description" rows="6">{{ get_setting('site_description') ?? old('site_description') }}</textarea>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Basic -->
            <!-- Media -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Media') }}</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-4">
                                        <x-form.btn-select-image type="single" input="site_logo"
                                            title="{{ __('Website Logo') }}"
                                            value="{{ old('site_logo', get_setting('site_logo')) }}" />
                                        <div class="mt-2">
                                            <img class="img-avatar" src="{{ uploaded_asset(get_setting('site_logo')) }}"
                                                alt="Logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="mb-4">
                                        <x-form.btn-select-image type="single" input="site_favicon"
                                            title="{{ __('Website Favicon') }}"
                                            value="{{ old('site_favicon', get_setting('site_favicon')) }}" />
                                        <div class="mt-2">
                                            <img class="img-avatar"
                                                src="{{ uploaded_asset(get_setting('site_favicon')) }}" alt="Website Favicon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Media -->
            <!-- Themes -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Themes') }}</h3>
                </div>
                @php
                    $themes = ['default', 'amethyst', 'city', 'flat', 'modern', 'smooth'];
                @endphp
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <h2 class="content-heading border-bottom mb-4 pb-2">{{ 'Dashboard color' }}</h2>
                            <div class="row">
                                @foreach ($themes as $index => $theme)
                                    <div class="col-6 col-xl-4 py-4">
                                        <div class="form-check form-block">
                                            <input type="radio" class="form-check-input"
                                                id="theme-radio-{{ $theme }}" name="site_theme"
                                                value="{{ $theme }}" @checked(get_setting('site_theme') == $theme || $index == 0)>
                                            <label
                                                class="form-check-label bg-{{ $theme }} text-white-75 mx-auto mb-2"
                                                for="theme-radio-{{ $theme }}">
                                                <i class="fa fa-paint-roller"></i>
                                            </label>
                                        </div>
                                        <div class="fw-semibold">{{ ucfirst($theme) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Themes -->
        </form>
    </div>
    <!-- END Page Content -->
@endsection
