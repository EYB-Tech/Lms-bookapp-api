@extends('admin.layouts.app')
@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css') }}">
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Page JS Code -->
    <!-- Page JS Helpers (Magnific Popup Plugin) -->
    <script type="module">
        One.helpersOnLoad(['jq-magnific-popup']);
    </script>
@endsection
@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [['label' => __('Dashboard'), 'url' => route('admin.dashboard')], ['label' => __('Uploads')]],
    ])
        @slot('title')
            {{ __('Uploads') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-primary">{{ $uploads->total() }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Total') . ' ' . __('Uploads') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">
                            {{ __('Unlimited') }}

                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Available Space') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">
                            {{ __('Unlimited') }}
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Remaining space') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-success">{{ format_size($totalSizeInBytes) }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Total Size') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->
        <!-- Quick Upload -->
        <div class="row">
            <div class="col-12">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <form action="{{ route('admin.uploads.store') }}" class="dropzone">
                            @csrf
                        </form>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Upload -->

        <!-- All Uploads -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('All') }} {{ __('Uploads') }}</h3>
                <div class="block-options">
                    <a href="{{ route('admin.uploads.index') }}" class="btn-block-option" data-toggle="block-option"
                        data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </a>

                    <div class="dropdown">
                        <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{ __('Filters') }} <i class="fa fa-angle-down ms-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.uploads.index', ['type' => 'image', 'search' => request()->search]) }}">
                                {{ __('Images') }}
                                <span class="badge bg-success rounded-pill">{{ $total_images }}</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.uploads.index', ['type' => 'application', 'search' => request()->search]) }}">
                                {{ __('Applications') }}
                                <span class="badge bg-warning rounded-pill">{{ $total_applications }}</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('admin.uploads.index', ['type' => null, 'search' => request()->search]) }}">
                                {{ __('All') }}
                                <span class="badge bg-primary rounded-pill">{{ $uploads->total() }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <!-- Search Form -->
                <form action="{{ route('admin.uploads.index') }}" method="GET">
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

                <!-- All Products Table -->
                <div class="row items-push">
                    @forelse ($uploads as $upload)
                        <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                            <!-- Uploads -->
                            @if ($upload->type == 'image')
                                <a class="block block-rounded bg-image h-100 mb-0"
                                    style="background-image: url('{{ getImage($upload->path) }}');"
                                    href="{{ route('admin.uploads.edit', $upload->id) }}">
                                @else
                                    <a class="block block-rounded bg-image h-100 mb-0"
                                        style="background-image: url('{{ getImage('media/photos/file-zip.png') }}');"
                                        href="{{ route('admin.uploads.edit', $upload->id) }}">
                            @endif
                            <div class="block-content bg-black-50">
                                <div class="mb-5 mb-sm-7 d-sm-flex justify-content-sm-between align-items-sm-center">
                                    <p>
                                        @if ($upload->type == 'image')
                                            <span class="badge bg-success fw-bold p-2 text-uppercase">
                                                {{ __('Image') }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning fw-bold p-2 text-uppercase">
                                                {{ __('Application') }}
                                            </span>
                                        @endif
                                    </p>
                                </div>
                                <p class="fs-lg fw-bold text-white mb-0"
                                    style="text-overflow: ellipsis;overflow: hidden;width: 100%; white-space: nowrap;">
                                    {{ $upload->title }}
                                </p>
                                <p class="fw-medium text-white-75">
                                    {{ format_size($upload->size) }} &middot;
                                    {{ $upload->created_at->diffForHumans() }}
                                </p>
                            </div>
                            </a>
                            <!-- END Uploads -->
                        </div>
                    @empty
                        <div class="content content-full text-muted fs-sm fw-medium text-center">
                            <p class="mb-1">
                                {{ __('Not Found Data') }}
                            </p>
                        </div>
                    @endforelse
                </div>
                <!-- END All Uploads Table -->

                <!-- Pagination -->
                <nav aria-label="Photos Search Navigation">
                    <ul class="pagination pagination-sm justify-content-end mt-2">
                        {{ $uploads->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                <!-- END Pagination -->
            </div>
        </div>
        <!-- END All Uploads -->
    </div>
    <!-- END Page Content -->
@endsection
