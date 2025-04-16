@extends('admin.layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Actions -->
        <div class="row">
            <div class="col-6">
                <a class="block block-rounded block-link-shadow text-center"
                    href="{{ route('admin.students.edit', $student->id) }}">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">
                            <i class="fa fa-pencil-alt"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Edit') }} {{ __('Student') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)"
                    onclick="event.preventDefault(); 
                                        if (confirm('Are you sure?')) {
                                            document.getElementById('delete-form-{{ $student->id }}').submit();
                                        }">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-danger">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-danger mb-0">
                            {{ __('Remove') }} {{ __('Student') }}
                        </p>
                    </div>
                </a>
                <form action="{{ route('admin.students.destroy', $student->id) }}" id="delete-form-{{ $student->id }}"
                    method="post" style="display: none">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                </form>
            </div>
        </div>
        <!-- END Quick Actions -->

        <!-- User Info -->
        <div class="block block-rounded">
            <div class="block-content text-center">
                <div class="py-4">
                    <div class="mb-3">
                        <img class="img-avatar" src="{{ getAvatar($student->image) }}" alt="{{ $student->name }}">
                    </div>
                    <h1 class="fs-lg mb-0">
                        <span>{{ $student->name }}</span>
                    </h1>
                    <p class="fs-sm fw-medium text-muted">{{ $student->username ?? $student->email }}</p>
                </div>
            </div>
            <div class="block-content bg-body-light text-center">
                <div class="row items-push text-uppercase">
                    <div class="col-6 col-md-6">
                        <div class="fw-semibold text-dark mb-1">{{ __('Subscriptions') }}</div>
                        <a class="link-fx fs-3 text-primary" href="javascript:void(0)">{{ $subscriptions->count() }}</a>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="fw-semibold text-dark mb-1">{{ __('Active Courses') }}</div>
                        <a class="link-fx fs-3 text-primary" href="javascript:void(0)">{{ $courses?->count() ?? 0 }}</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END User Info -->

        <!-- Devices -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Devices') }} ({{ $devices->count() }})</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">#</th>
                                <th>{{ __('Device Name') }}</th>
                                <th>{{ __('IP Address') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devices as $index => $device)
                                <tr>
                                    <td class="text-center fs-sm">
                                        <strong>{{ $index + 1 }}</strong>
                                    </td>
                                    <td>
                                        {{ $device->device_name }}
                                    </td>
                                    <td>
                                        {{ $device->ip_address }}
                                    </td>
                                    <td class="text-center fs-sm">
                                        <a class="btn btn-sm btn-alt-danger" href="javascript:void(0)"
                                            onclick="event.preventDefault(); 
                                if (confirm('Are you sure?')) {
                                    document.getElementById('delete-form-{{ $device->id }}').submit();
                                }"
                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i>
                                        </a>
                                        <form action="{{ route('admin.devices.destroy', $device->id) }}"
                                            id="delete-form-{{ $device->id }}" method="post" style="display: none">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination pagination-sm justify-content-end mt-2">
                        {{ $subscriptions->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END Devices -->
        <!-- Subscriptions -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Subscriptions') }} ({{ $subscriptions->count() }})</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">ID</th>
                                <th class="d-none d-md-table-cell text-center">{{ __('Course') }}</th>
                                <th>{{ __('Submitted') }}</th>
                                <th class="d-none d-xl-table-cell text-center">{{ __('Start') }}</th>
                                <th class="d-none d-sm-table-cell text-end">{{ __('End') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td class="text-center fs-sm">
                                        <a class="fw-semibold"
                                            href="{{ route('admin.subscriptions.show', $subscription->id) }}">
                                            <strong>Sub.{{ $subscription->id }}</strong>
                                        </a>
                                    </td>
                                    <td class="d-none d-md-table-cell text-center fs-sm">
                                        <a
                                            href="{{ route('admin.courses.show', $subscription->course_id) }}">{{ $subscription?->course?->name }}</a>
                                    </td>
                                    <td>
                                        {{ $subscription->created_at->diffForHumans() }}</td>
                                    <td class="d-none d-xl-table-cell text-center fs-sm">
                                        {{ $subscription->start_date }}
                                    </td>
                                    <td class="d-none d-sm-table-cell text-end fs-sm">
                                        {{ $subscription->end_date }}
                                    </td>
                                    <td class="text-center fs-sm">
                                        <a class="btn btn-sm btn-alt-secondary"
                                            href="{{ route('admin.subscriptions.show', $subscription->id) }}"
                                            data-bs-toggle="tooltip" title="View">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination pagination-sm justify-content-end mt-2">
                        {{ $subscriptions->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END Subscriptions -->
    </div>
    <!-- END Page Content -->
@endsection
