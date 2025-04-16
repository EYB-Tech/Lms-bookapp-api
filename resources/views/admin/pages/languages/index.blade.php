@extends('admin.layouts.app')
@section('js')
    <!-- Page JS Code -->
    @vite(['resources/js/pages/admin/languages.js'])
@endsection
@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [['label' => __('Dashboard'), 'url' => route('admin.dashboard')], ['label' => __('Languages')]],
    ])
        @slot('title')
            {{ __('Languages') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)" data-bs-toggle="modal"
                    data-bs-target="#add-modal">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-success">
                            <i class="fa fa-plus"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-success mb-0">
                            {{ __('Add') }} {{ __('Language') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)"
                    data-bs-toggle="modal" data-bs-target="#add-word-modal">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-success">
                            <i class="fa fa-plus"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-success mb-0">
                            {{ __('Add') }} {{ __('Word') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-danger">{{ $total_not_available_languages }}</div>
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
                        <div class="fs-2 fw-semibold text-dark">{{ $total_available_languages }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Active') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->
        <!-- All Languages -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('All') }} {{ __('Languages') }}</h3>
                <div class="block-options">
                    <div class="dropdown">
                        <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{ __('Filters') }} <i class="fa fa-angle-down ms-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.languages.index', ['status' => 'Draft', 'search' => request()->search]) }}">
                                {{ __('Not available') }}
                                <span class="badge bg-danger rounded-pill">{{ $total_not_available_languages }}</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.languages.index', ['status' => 'Publish', 'search' => request()->search]) }}">
                                {{ __('Available') }}
                                <span class="badge bg-success rounded-pill">{{ $total_available_languages }}</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.languages.index', ['status' => null, 'search' => request()->search]) }}">
                                {{ __('All') }}
                                <span class="badge bg-primary rounded-pill">{{ $languages->total() }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <!-- Search Form -->
                <form action="{{ route('admin.languages.index') }}" method="GET">
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
                <!-- All Languages Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">{{ __('Language') }}</th>
                                <th class="d-none d-sm-table-cell text-center">{{ __('Direction') }}</th>
                                <th class="d-none d-sm-table-cell text-center">{{ __('Status') }}</th>
                                <th>{{ __('Default') }}</th>
                                <th class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($languages as $language)
                                <tr>
                                    <td class="text-center fs-sm">
                                        <a class="fw-semibold"
                                            href="{{ route('admin.languages.show', $language->id) }}">
                                            <strong>{{ $language->name }}</strong>
                                        </a>
                                    </td>

                                    <td class="d-none d-sm-table-cell text-center fs-sm">
                                        {{ $language->direction }}
                                    </td>
                                    <td class="d-none d-sm-table-cell text-center fs-sm">
                                        @if ($language->status == 'Publish')
                                            <span class="badge bg-success">{{ __('Available') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('Not available') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('admin.languages.make-default', $language->id) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('put') }}
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" onchange="this.form.submit()"
                                                    id="defaultCheck" name="default" @checked($language->default)>
                                                <label class="form-check-label" for="defaultCheck"></label>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-center fs-sm">
                                        <a class="btn btn-sm btn-alt-secondary modal-edit" href="javascript:void(0)"
                                            data-bs-toggle="modal" data-bs-target="#edit-modal" data-bs-toggle="tooltip"
                                            title="{{ __('Edit') }}" data-language="{{ $language }}">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-alt-danger" href="javascript:void(0)"
                                            onclick="event.preventDefault(); 
                                        if (confirm('Are you sure?')) {
                                            document.getElementById('delete-form-{{ $language->id }}').submit();
                                        }"
                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i>
                                        </a>
                                        <form action="{{ route('admin.languages.destroy', $language->id) }}"
                                            id="delete-form-{{ $language->id }}" method="post" style="display: none">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
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
                <!-- END All Languages Table -->
                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination pagination-sm justify-content-end mt-2">
                        {{ $languages->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END All Languages -->

        <!-- Add Word Modal -->
        @include('admin.pages.languages.add-word-model')
        <!-- END Add Word Modal -->
        <!-- Add Language Modal -->
        @include('admin.pages.languages.add-language-model')
        <!-- END Add Language Modal -->
        <!-- Edit Language Modal -->
        @include('admin.pages.languages.edit-language-model')
        <!-- END Edit Language Modal -->
    </div>
    <!-- END Page Content -->
@endsection
