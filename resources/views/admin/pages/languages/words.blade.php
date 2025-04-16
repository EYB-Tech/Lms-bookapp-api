<div class="row">
    @foreach ($all_word as $key => $value)
        <div class="col-md-6 col-xl-3 card-item">
            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">
                        <small>{{ $key }}</small>
                    </h3>
                </div>
                <div class="block-content">
                    <form method="POST" action="{{ route('admin.languages.update-words', $language->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <input type="hidden" name="string_key" value="{{ $key }}">
                        <div class="mb-4">
                            <textarea class="form-control" id="translate_word" name="translate_word" rows="3">{{ $value }}</textarea>
                        </div>
                        <div class="mb-4 text-center">
                            <button type="button" class="btn btn-alt-primary save-words" data-toggle="block-option"
                                data-action="state_toggle" data-action-mode="demo">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
