<div class="mb-4">
    @if ($label)
        <label class="form-label" for="{{ $id ?: $name }}">{{ $label }}</label>
    @endif
    <textarea class="form-control @error(preg_replace('/\[(.*?)\]/', '.$1', $name)) is-invalid @enderror {{ $class }}"
        id="{{ $id ?: $name }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}">{{ old(preg_replace('/\[(.*?)\]/', '.$1', $name), $value) }}</textarea>
    @error(preg_replace('/\[(.*?)\]/', '.$1', $name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
