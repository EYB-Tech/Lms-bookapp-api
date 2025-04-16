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
    <div class="bg-image" style="background-image: url('{{ getImage($lesson->course?->thumbnail?->path) }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center py-7 pb-5">
                <h1 class="h2 text-white mb-2">
                    {{ $lesson->name }}
                </h1>
                <h2 class="h4 fw-normal text-white-75">
                    {{ $lesson->course->name }}
                </h2>

                <a class="btn btn-alt-secondary" href="{{ route('admin.lessons.edit', $lesson->id) }}" data-bs-toggle="tooltip"
                    title="{{ __('Edit') }}">
                    <i class="fa fa-fw fa-edit text-info"></i> {{ __('Edit') }}
                </a>
                <a class="btn btn-alt-secondary" href="javascript:void(0)"
                    onclick="event.preventDefault(); 
            if (confirm('Are you sure?')) {
                document.getElementById('delete-form-{{ $lesson->id }}').submit();
            }"
                    data-bs-toggle="tooltip" title="{{ __('Remove') }}">
                    <i class="fa fa-fw fa-times text-danger"></i> {{ __('Remove') }}
                </a>
                <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" id="delete-form-{{ $lesson->id }}"
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
            ['label' => $lesson->course->name, 'url' => route('admin.courses.show', $lesson->course_id)],
            ['label' => $lesson->name],
        ],
    ])
    @endcomponent
    <!-- END Navigation -->
    <!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-8">
                <!-- Lesson -->
                <div class="block block-rounded">
                    <div class="block-content">
                        <h3>
                            {{ $lesson->name }}
                            @if ($lesson->can_view_without_pay)
                                ({{ __('Free Preview') }})
                            @endif
                        </h3>
                        @include('admin.pages.lessons.partials.file')
                        <hr>
                        {!! $lesson->description !!}
                    </div>
                </div>
                <!-- END Lesson -->
            </div>
            <div class="col-xl-4">

                <!-- Course Info -->
                <div class="block block-rounded">
                    <div class="block-header block-header-default text-center">
                        <h3 class="block-title">{{ __('About This Lesson') }}</h3>
                    </div>
                    <div class="block-content">
                        <table class="table table-striped table-borderless fs-sm">
                            <tbody>
                                <tr>
                                    <td>
                                        <i class="fa fa-fw fa-book me-1"></i>
                                        {{ __(ucfirst(str_replace(['-', '_'], ' ', $lesson->type))) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-fw fa-eye me-1"></i>
                                        {{ $lesson->view_count }} {{ __('Maximum number of views') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-fw fa-user me-1"></i>
                                        {{ $lesson->students->sum('pivot.views') }} {{ __('Students of views') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-fw fa-calendar me-1"></i>
                                        {{ $lesson->updated_at->diffForHumans() }}
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
