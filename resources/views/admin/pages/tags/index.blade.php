@extends('admin.layouts.app')

@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [['label' => __('Dashboard'), 'url' => route('admin.dashboard')], ['label' => __('Tags')]],
    ])
        @slot('title')
            {{ __('Tags') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-6">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('admin.tags.create') }}">
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
            <div class="col-6 col-lg-6">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">{{ $tags->total() }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('All') }} {{ __('Tags') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->
        <!-- All Tags -->
        <div class="block block-rounded">
            <div class="block-content">
                <!-- Search Form -->
                <form action="{{ route('admin.tags.index') }}" method="GET">
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
                <!-- All Tags Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th style="width: 30%;">{{ __('Created At') }}</th>
                                <th class="text-center" style="width: 100px;">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tags as $tag)
                                <tr>
                                    <td class="fw-semibold fs-sm">
                                        {{ $tag->name }}
                                    </td>
                                    <td class="fs-sm">{{ $tag->created_at }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-alt-secondary"
                                                href="{{ route('admin.tags.edit', $tag->id) }}" data-bs-toggle="tooltip"
                                                title="{{ __('Edit') }}">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-alt-danger" href="javascript:void(0)"
                                                onclick="event.preventDefault();
                                        if (confirm('Are you sure?')) {
                                            document.getElementById('delete-form-{{ $tag->id }}').submit();
                                        }"
                                                data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                <i class="fa fa-fw fa-times text-danger"></i>
                                            </a>
                                            <form action="{{ route('admin.tags.destroy', $tag->id) }}"
                                                id="delete-form-{{ $tag->id }}" method="post" style="display: none">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">

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
                <!-- END All Tags Table -->
                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination pagination-sm justify-content-end mt-2">
                        {{ $tags->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END All Tags -->
    </div>
    <!-- END Page Content -->
@endsection
