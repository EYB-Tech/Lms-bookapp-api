@extends('admin.layouts.app')

@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [['label' => __('Dashboard'), 'url' => route('admin.dashboard')], ['label' => __('Students')]],
    ])
        @slot('title')
            {{ __('Students') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('admin.students.create') }}">
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
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)"
                    data-bs-toggle="modal" data-bs-target="#import-students-modal">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-success">
                            <i class="fa fa-plus"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-success mb-0">
                            {{ __('Import') }} {{ __('Students') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-danger">{{ $total_not_available_students }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-danger mb-0">
                            {{ __('Not Active') }}
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">{{ $students->total() }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('All') }} {{ __('Students') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->
        <!-- All Students -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('All') }} {{ __('Students') }}</h3>
                <div class="block-options">
                    <div class="dropdown">
                        <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{ __('Filters') }} <i class="fa fa-angle-down ms-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.students.index', ['status' => '0', 'search' => request()->search]) }}">
                                {{ __('Not available') }}
                                <span class="badge bg-danger rounded-pill">{{ $total_not_available_students }}</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.students.index', ['status' => '1', 'search' => request()->search]) }}">
                                {{ __('Available') }}
                                <span class="badge bg-success rounded-pill">{{ $total_available_students }}</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.students.index', ['status' => null, 'search' => request()->search]) }}">
                                {{ __('All') }}
                                <span class="badge bg-primary rounded-pill">{{ $students->total() }}</span>
                            </a>
                            {{--  --}}
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.students.index', ['status_devices' => '0', 'search' => request()->search]) }}">
                                {{ __('Not registered with devices') }}
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.students.index', ['status_devices' => '1', 'search' => request()->search]) }}">
                                {{ __('Registered with devices') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <!-- Search Form -->
                <form action="{{ route('admin.students.index') }}" method="GET">
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
                <!-- All Students Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">
                                    <i class="far fa-user"></i>
                                </th>
                                <th>{{ __('Name') }}</th>
                                <th style="width: 20%;">{{ __('Username') }}</th>
                                <th style="width: 30%;">{{ __('Email') }}</th>
                                <th style="width: 15%;">{{ __('Devices') }}</th>
                                <th style="width: 15%;">{{ __('Access') }}</th>
                                <th class="text-center" style="width: 100px;">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td class="text-center">
                                        <img class="img-avatar img-avatar48" src="{{ getAvatar($student->image) }}"
                                            alt="{{ $student->name }}">
                                    </td>
                                    <td class="fw-semibold fs-sm">
                                        <a
                                            href="{{ route('admin.students.show', $student->id) }}">{{ $student->name }}</a>
                                    </td>
                                    <td class="fs-sm">{{ $student->username }}</td>
                                    <td class="fs-sm">{{ $student->email }}</td>
                                    <td class="fs-sm">
                                        @if ($student?->device)
                                            <a class="btn btn-sm btn-alt-danger" href="javascript:void(0)"
                                                onclick="event.preventDefault(); 
                    if (confirm('Are you sure?')) {
                        document.getElementById('delete-device-{{ $student?->device?->id }}').submit();
                    }"
                                                data-bs-toggle="tooltip" title="{{ __('Delete') . ' ' . __('Device') }}">
                                                <i class="fa fa-fw fa-tablet-screen-button text-danger"></i>
                                                {{ $student?->device?->device_name }}
                                            </a>
                                            <form action="{{ route('admin.devices.destroy', $student?->device?->id) }}"
                                                id="delete-device-{{ $student?->device?->id }}" method="post"
                                                style="display: none">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($student->email_verified_at)
                                            <span
                                                class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">{{ __('Available') }}</span>
                                        @else
                                            <span
                                                class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">{{ __('Not available') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-alt-secondary"
                                                href="{{ route('admin.students.edit', $student->id) }}"
                                                data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-alt-danger" href="javascript:void(0)"
                                                onclick="event.preventDefault(); 
                                        if (confirm('Are you sure?')) {
                                            document.getElementById('delete-form-{{ $student->id }}').submit();
                                        }"
                                                data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                <i class="fa fa-fw fa-times text-danger"></i>
                                            </a>
                                            <form action="{{ route('admin.students.destroy', $student->id) }}"
                                                id="delete-form-{{ $student->id }}" method="post"
                                                style="display: none">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </div>
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
                <!-- END All Students Table -->
                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination pagination-sm justify-content-end mt-2">
                        {{ $students->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END All Students -->
        <!-- Add Word Modal -->
        @include('admin.pages.students.import-students-model')
        <!-- END Add Word Modal -->
    </div>
    <!-- END Page Content -->
@endsection
