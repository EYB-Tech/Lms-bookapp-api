@extends('admin.layouts.app')
@section('content')
    <!-- Hero -->
    <div class="bg-image" style="background-image: url('{{ asset('media/photos/photo10@2x.jpg') }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center">
                <div class="my-3">
                    <img class="img-avatar img-avatar-thumb" src="{{ getAvatar($student->image) }}" alt="{{ $student->name }}">
                </div>
                <h1 class="h2 text-white mb-0">{{ $student->name }}</h1>
                <h2 class="h4 fw-normal text-white-75">
                    {{ __($student->email) }}
                </h2>
                @if (auth()->user()->hasRole('super_admin'))
                <a class="btn btn-alt-secondary" href="{{ route('admin.users.impersonate', $student->id) }}"
                    data-bs-toggle="tooltip" title="{{ __('Impersonate') }}">
                    <i class="fa fa-fw fa-user-secret text-info"></i> {{ __('Impersonate') }}
                </a>
                @endif
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content content-boxed">
        <!-- User Profile -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Profile') }}</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.students.update', $student->id) }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <x-form.base-input type="text" name="name" label="{{ __('Name') }}" value="{{$student->name}}" />
                                </div>
                                <div class="col-12">
                                    <x-form.base-input type="text" name="username" label="{{ __('Username') }}" value="{{$student->username}}" />
                                </div>
                                <div class="col-12">
                                    <x-form.base-input type="email" name="email" label="{{ __('Email') }}" value="{{$student->email}}"/>
                                </div>
                                <div class="col-12">
                                    <x-form.base-input type="text" name="phone" label="{{ __('Phone') }}" value="{{$student->phone}}" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">{{ __('Avatar') }}</label>
                                <div class="mb-4">
                                    <img class="img-avatar" src="{{ getAvatar($student->image) }}" alt="{{ $student->name }}">
                                </div>
                            <x-form.base-input type="file" name="image" label="{{ __('Choose a new avatar') }}" />
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END User Profile -->

        <!-- Change Password -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Change Password') }}</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.users.change-password', $student->id) }}" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label" for="new_password">{{ __('New Password') }}</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label"
                                        for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation">
                                </div>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Change Password -->
    </div>
    <!-- END Page Content -->
@endsection
