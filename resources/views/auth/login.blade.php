@extends('admin.layouts.simple')

@section('content')
    <!-- Page Content -->
    @if (get_setting('login_page_image'))
        <div class="bg-image" style="background-image: url('{{ uploaded_asset(get_setting('login_page_image')) }}');">
        @else
            <div class="bg-primary-dark">
    @endif
    <div class="row g-0 bg-primary-dark-op">
        <!-- Meta Info Section -->
        <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
            <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                <div class="w-100">
                    <a class="link-fx fw-semibold fs-2 text-white" href="{{ route('home') }}">
                        {{ get_setting('site_title') }}
                    </a>
                    {{-- <p class="text-white-75 me-xl-8 mt-2"> --}}
                    <p class="text-white-75 mt-2">
                        {{ get_setting('login_page_content', __('Description login page here'), default_lang()) }}
                    </p>
                </div>
            </div>
            <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm">
                <p class="fw-medium text-white-50 mb-0">
                    <strong>{!! get_setting('site_footer_copyright') !!}</strong> &copy; <span data-toggle="year-copy"></span>
                </p>
                <ul class="list list-inline mb-0 py-2">
                    @foreach (all_active_language() as $language)
                        <li class="list-inline-item mx-1">
                            <a class="text-white-75 fw-medium" rel="alternate"
                                href="{{ LaravelLocalization::getLocalizedURL($language->slug, null, [], true) }}">{{ $language->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- END Meta Info Section -->

        <!-- Main Section -->
        <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-body-extra-light">
            <div class="p-3 w-100 d-lg-none text-center">
                <a class="link-fx fw-semibold fs-3 text-dark" href="{{ route('home') }}">
                    {{ get_setting('site_title') }}
                </a>
            </div>
            <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                <div class="w-100">
                    <!-- Header -->
                    <div class="text-center mb-5">
                        <p class="mb-3">
                            <img class="img-fluid" style="height: 60px" src="{{ uploaded_asset(get_setting('site_logo')) }}"
                                alt="{{ get_setting('site_title') }}">
                        </p>
                        <h1 class="fw-bold mb-2">
                            {{ get_setting('site_title') }}
                        </h1>
                    </div>
                    <!-- END Header -->

                    <!-- Sign In Form -->
                    <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <div class="row g-0 justify-content-center">
                        <div class="col-sm-8 col-xl-4">
                            @if (session('success'))
                                <x-alert type="success">
                                    {{ session('success') }}
                                </x-alert>
                            @endif
                            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                @csrf
                                <div class="mb-4">
                                    <input type="text"
                                        class="form-control form-control-lg form-control-alt py-3 @error('login') is-invalid @enderror"
                                        name="login" placeholder="{{ __('Email Or Username') }}" value="{{ old('login') }}">

                                    @error('login')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <input type="password"
                                        class="form-control form-control-lg form-control-alt py-3 @error('password') is-invalid @enderror"
                                        name="password" placeholder="{{ __('Password') }}">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    @if (Route::has('password.reminder'))
                                        <div>
                                            <a class="text-muted fs-sm fw-medium d-block d-lg-inline-block mb-1"
                                                href="{{ route('password.reminder') }}">
                                                {{ __('Forgot Password') }}?
                                            </a>
                                        </div>
                                    @endif
                                    <div>
                                        <button type="submit" class="btn btn-lg btn-alt-primary">
                                            <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> {{ __('Sign In') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END Sign In Form -->
                </div>
            </div>
            <div
                class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between fs-sm text-center text-sm-start">
                <p class="fw-medium text-black-50 py-2 mb-0">
                    <strong>{!! get_setting('site_footer_copyright') !!}</strong> &copy; <span data-toggle="year-copy"></span>
                </p>
                <ul class="list list-inline py-2 mb-0">
                    @foreach (all_active_language() as $language)
                        <li class="list-inline-item mx-1">
                            <a class="text-muted fw-medium" rel="alternate"
                                href="{{ LaravelLocalization::getLocalizedURL($language->slug, null, [], true) }}">{{ $language->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- END Main Section -->
    </div>
    </div>
    <!-- END Page Content -->
@endsection
