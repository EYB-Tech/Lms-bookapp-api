@extends('admin.layouts.app')
@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/chart.js/chart.umd.js') }}"></script>
    <!-- Page JS Code -->
    @vite(['resources/js/pages/dashboard.js'])
@endsection
@section('content')
    <!-- Hero -->
    <div class="content">
        <div
            class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">
                    {{ __('Dashboard') }}
                </h1>
                <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                    {{ __('Welcome') }} <a class="fw-semibold"
                        href="{{ route('admin.profile') }}">{{ explode(' ', Auth::user()->name)[0] }}</a>,
                    {{ __('everything looks great') }}.
                </h2>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    {{-- <div class="content">
        <!-- Overview -->
        <div class="row items-push">
            <div class="col-sm-6 col-xxl-3">
                <!-- Pending Orders -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $total_new_applications }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">
                                {{ __('New Applications This Week') }}
                            </dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="far fa-paper-plane fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                            href="{{ route('admin.contacts.index') }}">
                            <span>{{ __('View all applications') }}</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END Pending Orders -->
            </div>
            <div class="col-sm-6 col-xxl-3">
                <!-- New Customers -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $total_new_customers }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">{{ __('New Customers This Week') }}
                            </dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="far fa-user-circle fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                            href="{{ route('admin.staffs.index') }}">
                            <span>{{ __('View all customers') }}</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END New Customers -->
            </div>
            <div class="col-sm-6 col-xxl-3">
                <!-- Projects -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $total_new_projects }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">{{ __('New Projects This Week') }}
                            </dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="far fa-gem fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                            href="{{ route('admin.projects.index') }}">
                            <span>{{ __('View all projects') }}</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END Projects -->
            </div>
            <div class="col-sm-6 col-xxl-3">
                <!-- Conversion Rate -->
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div
                        class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $total_new_works }}</dt>
                            <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">{{ __('New Works This Week') }}
                            </dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-chart-bar fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="bg-body-light rounded-bottom">
                        <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                            href="{{ route('admin.projects.index') }}">
                            <span>{{ __('View all works') }}</span>
                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                        </a>
                    </div>
                </div>
                <!-- END Conversion Rate-->
            </div>
        </div>
        <!-- END Overview -->

        <!-- Statistics -->

        <!-- END Statistics -->
    </div> --}}
    <!-- END Page Content -->
@endsection
