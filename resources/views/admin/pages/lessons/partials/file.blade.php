    @if ($lesson?->attached)
        <embed src="{{ route('admin.files.stream', $lesson->attached->id) }}"
            type="{{ $lesson->attached->type . '/' . $lesson->attached->extension }}" width="100%" height="500px">
    @else
        <h5 class="text-center">{{ __('Not Found File') }}</h5>
    @endif
