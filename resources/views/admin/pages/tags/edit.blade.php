@extends('admin.layouts.app')
@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Tags'), 'url' => route('admin.tags.index')],
            ['label' => $tag->slug],
            ['label' => __('Edit')],
        ],
    ])
        @slot('title')
            {{ __('Edit') }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Page Content -->
    <div class="content">
        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('put') }}

            <!-- Info -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Info') }}</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <x-form.base-input type="text" name="name" label="{{ __('Name') }}"
                                value="{{ $tag?->name }}" />
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Info -->
        </form>
    </div>
    <!-- END Page Content -->
@endsection
