@extends('admin.layouts.app')

@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [['label' => __('Dashboard'), 'url' => route('admin.dashboard')], ['label' => __('Staffs')]],
    ])
        @slot('title')
            {{ __('Staffs') }}
        @endslot
    @endcomponent
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-6">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('admin.staffs.create') }}">
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
                        <div class="fs-2 fw-semibold text-dark">{{ $staffs->total() }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('All') }} {{ __('Staffs') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->
        <!-- All Staffs -->
        <div class="row">
            @foreach ($staffs as $staff)
                <div class="col-md-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-center"
                        href="{{ route('admin.staffs.edit', $staff->id) }}">
                        <div class="block-content block-content-full bg-body-light">
                            <img class="img-avatar" src="{{ getAvatar($staff->image) }}" alt="{{ $staff->name }}">
                        </div>
                        <div class="block-content block-content-full">
                            <p class="fw-semibold mb-0">{{ $staff->name }}</p>
                            <p class="fs-sm fw-medium text-muted mb-0">
                                {{ $staff->email }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- END All Staffs -->
    </div>
    <!-- END Page Content -->
@endsection
