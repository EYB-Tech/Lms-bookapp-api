@extends('admin.layouts.app')

@section('content')
    <!-- Page Content -->
    <div class="content">

        <!-- Quick Overview + Actions -->
        <div class="row">
            <div class="col-6 col-lg-4">
                <a class="block block-rounded block-link-shadow text-center" href="{{ route('admin.uploads.index') }}">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">
                            <i class="si si-action-redo"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Back') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-4">
                <a class="block block-rounded block-link-shadow text-center"href="javascript:void(0)"
                    onclick="event.preventDefault();
              document.getElementById('form-info').submit();">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">
                            <i class="fa fa-edit"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Update') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">

                <form action="{{ route('admin.uploads.destroy', $upload->id) }}" id="delete-form-{{ $upload->id }}"
                    method="post" style="display: none">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                </form>


                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)"
                    onclick="event.preventDefault(); 
            if (confirm('Are you sure?')) {
                document.getElementById('delete-form-{{ $upload->id }}').submit();
            }">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-danger">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-danger mb-0">
                            {{ __('Remove') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview + Actions -->
        <!-- Info -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Info') }}</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.uploads.update', $upload->id) }}" method="POST" id="form-info">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <div class="mb-4">
                                <label class="form-label" for="title">{{ __('Title') }}</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $upload->title ?? old('title') }}">
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Extra Info Tabs -->
                <div class="block block-rounded">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <div class="table-responsive">

                                <table class="table table-striped table-borderless">
                                    <thead>
                                        <tr>
                                            <th colspan="2">{{ __('Extra') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 30%;">
                                                <i class="fa fa-fw fa-calendar text-muted me-1"></i> {{ __('Added') }}
                                            </td>
                                            <td>{{ $upload->created_at->format('Y ,d M') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%;">
                                                <i class="fa fa-fw fa-user text-muted me-1"></i> {{ __('Added By') }}
                                            </td>
                                            <td>{{ $upload->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fa fa-fw fa-anchor text-muted me-1"></i> {{ __('File Size') }}
                                            </td>
                                            <td>{{ format_size($upload->size) }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fa fa-fw fa-file-circle-question text-muted me-1"></i>
                                                {{ __('Type') }}
                                            </td>
                                            <td>
                                                {{ $upload->type }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fa fa-fw fa-vector-square text-muted me-1"></i>
                                                {{ __('Extension') }}
                                            </td>
                                            <td>
                                                {{ $upload->extension }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fa fa-fw fa-link text-muted me-1"></i> {{ __('Source') }}
                                            </td>
                                            <td>
                                                {{ asset($upload->path) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fa fa-fw fa-expand text-muted me-1"></i> {{ __('Perview') }}
                                            </td>
                                            <td>
                                                @if ($upload->type == 'image')
                                                    <img src="{{ asset($upload->path) }}" alt="{{ $upload->title }}" class="img-fluid">
                                                @endif
                                                @if ($upload->type == 'application')
                                                    <embed src="{{ route('admin.files.stream', $upload->id) }}"
                                                        type="{{ $upload->type . '/' . $upload->extension }}"
                                                        width="100%" height="500px">
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END Extra Info Tabs -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection
