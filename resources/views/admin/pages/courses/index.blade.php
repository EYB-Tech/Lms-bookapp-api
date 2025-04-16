@extends('admin.layouts.app')

@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [['label' => __('Dashboard'), 'url' => route('admin.dashboard')], ['label' => __('Courses')]],
    ])
        @slot('title')
            {{ __('Courses') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-6">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('admin.courses.create') }}">
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
                        <div class="fs-2 fw-semibold text-dark">{{ $courses->total() }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('All') }} {{ __('Courses') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->
        <!-- All Courses -->
        <div class="row">
            @forelse ($courses as $course)
                <div class="col-md-6 col-lg-4">
                    @component('components.admin.courses.course_card_v1', ['course' => $course])
                    @endcomponent
                </div>
            @empty
                <div class="col-12">
                    <div class="content content-full text-muted fs-sm fw-medium text-center">
                        <p class="mb-1">
                            {{ __('Not Found Data') }}
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- END All Courses -->
    </div>
    <!-- END Page Content -->
@endsection
