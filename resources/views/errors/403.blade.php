@extends('admin.layouts.simple')

@section('content')
    <!-- Page Content -->
    <div class="hero">
        <div class="hero-inner text-center">
            <div class="bg-body-extra-light">
                <div class="content content-full overflow-hidden">
                    <div class="py-4">
                        <!-- Error Header -->
                        <h1 class="display-1 fw-bolder text-flat">
                            403
                        </h1>
                        <h2 class="h4 fw-normal text-muted mb-5">
                            {{ __('We are sorry but you do not have permission to access this page..') }}
                        </h2>
                        <!-- END Error Header -->
                    </div>
                </div>
            </div>
            <div class="content content-full text-muted fs-sm fw-medium">
                <!-- Error Footer -->
                <a class="link-fx" href="{{ url('/') }}">{{ __('Go Back to Home') }}</a>
                <!-- END Error Footer -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
