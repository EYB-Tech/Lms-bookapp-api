<div class="form-floating mb-3">
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old(preg_replace('/\[(.*?)\]/', '.$1', $name), $value) }}"
        class="form-control  @error(preg_replace('/\[(.*?)\]/', '.$1', $name)) is-invalid @enderror {{ $class }}"
        id="{{ $id ?: $name }}" placeholder="{{ $placeholder }}">
    <label for="{{ $id ?: $name }}">{{ $label }}</label>
    @error(preg_replace('/\[(.*?)\]/', '.$1', $name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
