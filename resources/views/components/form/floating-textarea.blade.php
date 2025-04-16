<div class="form-floating mb-3">
    <textarea rows="{{ $rows }}" name="{{ $name }}" class="form-control @error(preg_replace('/\[(.*?)\]/', '.$1', $name)) is-invalid @enderror {{ $class }}"
         placeholder="{{ $placeholder }}" style="height: 100px" id="{{ $id ?: $name }}">{{ old(preg_replace('/\[(.*?)\]/', '.$1', $name), $value) }}</textarea>
    <label for="{{ $id ?: $name }}">{{ $label }}</label>
    @error(preg_replace('/\[(.*?)\]/', '.$1', $name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
