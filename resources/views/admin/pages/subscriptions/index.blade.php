@extends('admin.layouts.app')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection
@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Page JS Code -->
    <script type="module">
        One.helpersOnLoad(['jq-select2']);
    </script>
@endsection
@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Subscriptions')],
        ],
    ])
        @slot('title')
            {{ __('Subscriptions') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('admin.subscriptions.create') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-success">
                            <i class="fa fa-plus"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-success mb-0">
                            {{ __('Add') }} {{ __('New') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">{{ number_format($todaySubscriptionsCount) }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Today') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">{{ number_format($yesterdaySubscriptionsCount) }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Yesterday') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">{{ number_format($thisMonthSubscriptionsCount) }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('This Month') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

        <!-- All Subscriptions -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('All') }} {{ __('Subscriptions') }}</h3>
            </div>
            <div class="block-content">
                <!-- Search Form -->
                <form action="{{ route('admin.subscriptions.index') }}" method="GET">
                    <div class="mb-4">
                        <div class="input-group">
                            <input type="search" class="form-control form-control-alt" id="one-ecom-products-search"
                                name="search" value="{{ request()->search }}" placeholder="{{ __('Search') }}...">
                            <span class="input-group-text bg-body border-0">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
                <!-- END Search Form -->
                <!-- All Subscriptions Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">ID</th>
                                <th class="d-none d-sm-table-cell text-center">{{ __('Submitted') }}</th>
                                <th>{{ __('Course') }}</th>
                                <th class="d-none d-xl-table-cell">{{ __('Student') }}</th>
                                <th class="d-none d-xl-table-cell text-center">{{ __('Start') }}</th>
                                <th class="d-none d-sm-table-cell text-end">{{ __('End') }}</th>
                                <th class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscriptions as $subscription)
                                <tr>
                                    <td class="text-center fs-sm">
                                        <a class="fw-semibold"
                                            href="{{ route('admin.subscriptions.show', $subscription->id) }}">
                                            <strong>Sub.{{ $subscription->id }}</strong>
                                        </a>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-center fs-sm">
                                        {{ $subscription->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <a class="fw-semibold"
                                            href="{{ route('admin.courses.show', $subscription->course_id) }}">{{ $subscription?->course?->name }}</a>
                                    </td>
                                    <td class="d-none d-xl-table-cell fs-sm">
                                        <a class="fw-semibold"
                                            href="{{ route('admin.students.show', $subscription->student_id) }}">{{ $subscription?->student?->name }}</a>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-center fs-sm">
                                        {{ $subscription->start_date }}
                                    </td>
                                    <td class="d-none d-sm-table-cell text-end fs-sm">
                                        {{ $subscription->end_date }}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-alt-secondary"
                                            href="{{ __(route('admin.subscriptions.show', $subscription->id)) }}"
                                            data-bs-toggle="tooltip" title="View">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                        <a class="btn btn-sm btn-alt-danger" href="javascript:void(0)"
                                            onclick="event.preventDefault();
                                        if (confirm('Are you sure?')) {
                                            document.getElementById('delete-form-{{ $subscription->id }}').submit();
                                        }"
                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i>
                                        </a>
                                        <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}"
                                            id="delete-form-{{ $subscription->id }}" method="post" style="display: none">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">

                                        <div class="content content-full text-muted fs-sm fw-medium text-center">
                                            <p class="mb-1">
                                                {{ __('Not Found Data') }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- END All Subscriptions Table -->

                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination pagination-sm justify-content-end mt-2">
                        {{ $subscriptions->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END All Subscriptions -->
    </div>
    <!-- END Page Content -->
@endsection
