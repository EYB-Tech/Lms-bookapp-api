<div class="mb-4">
    @if ($label)
        <label class="form-label" for="{{ $id ?: $name }}">
            {{ $label }}
        </label>
    @endif
    <input type="{{ $type }}"
        class="form-control @error(preg_replace('/\[(.*?)\]/', '.$1', $name)) is-invalid @enderror {{ $class }}"
        id="{{ $id ?: $name }}" name="{{ $name }}"
        @if ($accept) accept="{{ $accept }}" @endif
        value="{{ old(preg_replace('/\[(.*?)\]/', '.$1', $name), $value) }}" placeholder="{{ $placeholder }}" 
        @foreach ($attrs as $attr => $value)
            {{ $attr }}="{{ $value }}"
        @endforeach />
    @error(preg_replace('/\[(.*?)\]/', '.$1', $name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
