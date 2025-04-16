<div class="block block-rounded">
    <div class="block-content pb-8 text-end bg-image"
        style="background-image: url('{{ getImage($course?->thumbnail?->path) }}');">
    </div>
    <div class="block-content text-center">
        <a class="fw-semibold text-dark" href="{{ route('admin.courses.show', $course->id) }}">
            {{ $course->name }}
        </a>
    </div>
    <div class="block-content block-content-full bg-body-light">
        <div class="row g-0 fs-sm text-center">
            <div class="col-4">
                <a class="text-muted fw-semibold" href="{{ route('admin.courses.show', $course->id) }}">
                    <i class="fa fa-fw fa-eye opacity-50 me-1"></i> {{ __('Show') }}
                </a>
            </div>
            <div class="col-4">
                <a class="text-muted fw-semibold" href="{{ route('admin.courses.edit', $course->id) }}">
                    <i class="fa fa-fw fa-edit opacity-50 me-1"></i> {{ __('Edit') }}
                </a>
            </div>
            <div class="col-4">
                <a class="text-muted fw-semibold" href="javascript:void(0)"
                    onclick="event.preventDefault(); 
                if (confirm('Are you sure?')) {
                    document.getElementById('delete-form-{{ $course->id }}').submit();
                }">
                    <i class="fa fa-fw fa-times text-danger opacity-50 me-1"></i> {{ __('Delete') }}
                </a>
                <form action="{{ route('admin.courses.destroy', $course->id) }}" id="delete-form-{{ $course->id }}"
                    method="post" style="display: none">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                </form>
            </div>
        </div>
    </div>
</div>
