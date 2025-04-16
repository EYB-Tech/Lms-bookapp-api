@extends('admin.layouts.app')
@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <!-- Page JS Code -->
    @vite(['resources/js/pages/admin/media_selection.js'])
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
            ['label' => __('Widgets Settings')],
        ],
    ])
        @slot('title')
            {{ __('Auth Layout Settings') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <!-- Vertical Block Tabs Default Style -->
        <div class="block block-rounded row g-0">
            <ul class="nav nav-tabs nav-tabs-block flex-md-column col-md-4" role="tablist">
                <li class="nav-item d-md-flex flex-md-column">
                    <button class="nav-link text-md-start active" id="btabs-vertical-login-page-tab" data-bs-toggle="tab"
                        data-bs-target="#btabs-vertical-login-page" role="tab" aria-controls="btabs-vertical-login-page"
                        aria-selected="true">
                        <i class="fa fa-fw fa-home opacity-50 me-1 d-none d-sm-inline-block"></i> {{ __('Login Page') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content col-md-8">
                <ul class="nav nav-tabs nav-tabs-block justify-content-center p-0" role="tablist">
                    @foreach (App\Models\Language::all() as $language)
                        <li class="nav-item flex-fill text-center">
                            <a href="{{ route('admin.settings.auth-layout', ['lang' => $language->slug]) }}"
                                class="nav-link {{ $lang == $language->slug ? 'active' : '' }}"
                                id="lang-static-{{ $language->slug }}-tab"
                                aria-selected="{{ $lang == $language->slug ? 'true' : 'false' }}">{{ $language->name }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="block-content tab-pane active" id="btabs-vertical-login-page" role="tabpanel"
                    aria-labelledby="btabs-vertical-login-page-tab" tabindex="0">
                    <h4 class="fw-semibold">{{ __('Login Page') }}</h4>
                    @include('admin.pages.website-setup.partials.auth-layout.login-page')
                </div>
            </div>
        </div>
        <!-- END Vertical Block Tabs Default Style -->
    </div>
    <!-- END Page Content -->
@endsection
