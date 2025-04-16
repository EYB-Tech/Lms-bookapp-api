@extends('admin.layouts.app')
@section('js')
    <!-- Page JS Code -->
    <!-- Page JS Helpers (Table Tools helpers) -->
    <script type="module">
        One.helpersOnLoad(['one-table-tools-sections']);
    </script>
@endsection
@section('content')
    <!-- Hero Content -->
    <div class="bg-image" style="background-image: url('{{ getImage($course?->thumbnail?->path) }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center py-7 pb-5">
                <h1 class="h2 text-white mb-2">
                    {{ $course->name }}
                </h1>
                <a class="btn btn-alt-secondary" href="{{ route('admin.courses.edit', $course->id) }}" data-bs-toggle="tooltip"
                    title="{{ __('Edit') }}">
                    <i class="fa fa-fw fa-edit text-info"></i> {{ __('Edit') }}
                </a>
                <a class="btn btn-alt-secondary" href="javascript:void(0)"
                    onclick="event.preventDefault(); 
            if (confirm('Are you sure?')) {
                document.getElementById('delete-form-{{ $course->id }}').submit();
            }"
                    data-bs-toggle="tooltip" title="{{ __('Remove') }}">
                    <i class="fa fa-fw fa-times text-danger"></i> {{ __('Remove') }}
                </a>
                <form action="{{ route('admin.courses.destroy', $course->id) }}" id="delete-form-{{ $course->id }}"
                    method="post" style="display: none">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                </form>
            </div>
        </div>
    </div>
    <!-- END Hero Content -->

    <!-- Navigation -->
    @component('components.admin.breadcrumb-two', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Courses'), 'url' => route('admin.courses.index')],
            ['label' => $course->name, 'url' => route('admin.courses.show', $course->id)],
        ],
    ])
    @endcomponent
    <!-- END Navigation -->
    <!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-8">
                <!-- Lessons -->
                <div class="block block-rounded">
                    <div class="block-content fs-sm">
                        <!-- All Contacts Table -->
                        <table class="table table-borderless table-vcenter">
                            <tbody>
                                @forelse ($course->lessons as $index => $lesson)
                                    <tr class="table-active">
                                        @if ($lesson->active)
                                            <td class="table-success text-center">
                                                <i class="fa fa-fw fa-unlock text-success"></i>
                                            </td>
                                        @else
                                            <td class="table-danger text-center">
                                                <i class="fa fa-fw fa-lock text-danger"></i>
                                            </td>
                                        @endif
                                        <td>
                                            <a class="fw-medium"
                                                href="{{ route('admin.lessons.show', $lesson->id) }}">{{ $lesson->name }}</a>
                                        </td>
                                        <td class="text-end text-muted">
                                            12 min
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
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
                        <!-- END All Contacts Table -->
                    </div>
                </div>
                <!-- END Lessons -->
            </div>
            <div class="col-xl-4">
                <!-- Subscribe -->
                <div class="block block-rounded">
                    <div class="block-content">
                        <a class="btn btn-primary w-100 mb-2"
                            href="{{ route('admin.lessons.create', $course->id) }}">{{ __('Create') }}
                            {{ __('Lesson') }}</a>
                    </div>
                </div>
                <!-- END Subscribe -->

                <!-- Course Info -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default text-center">
                        <h3 class="block-title">{{ __('About This Course') }}</h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-striped table-borderless fs-sm">
                            <tbody>
                                <tr>
                                    <td>
                                        <i class="fa fa-fw fa-book me-1"></i> {{ $course->lessons->count() }}
                                        {{ __('Lessons') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-fw fa-user me-1"></i> {{ $course->subscriptions->count() }}
                                        {{ __('Students') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END Course Info -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
