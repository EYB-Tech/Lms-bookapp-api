@extends('admin.layouts.app')

@section('content')
    <!-- Hero -->
    <div class="bg-image" style="background-image: url('{{ asset('media/photos/photo10@2x.jpg') }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center">
                <div class="my-3">
                    <img class="img-avatar img-avatar-thumb" src="{{ getAvatar($user->image) }}" alt="{{ $user->name }}">
                </div>
                <h1 class="h2 text-white mb-0"> {{ $user->name }}</h1>
                <h2 class="h4 fw-normal text-white-75">
                    {{ $user->email }}
                </h2>
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

                <form action="{{ route('admin.staffs.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="fs-sm text-muted">
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="mb-4">
                                <label class="form-label" for="name">{{ __('Name') }}</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your name.." value="{{ $user->name }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email.." value="{{ $user->email }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">{{ __('Avatar') }}</label>
                                <div class="mb-4">
                                    <img class="img-avatar" src="{{ getAvatar($user->image) }}" alt="{{ $user->name }}">
                                </div>
                                <div class="mb-4">
                                    <label for="one-profile-edit-avatar"
                                        class="form-label">{{ __('Choose a new avatar') }}</label>
                                    <input class="form-control" type="file" id="one-profile-edit-avatar" name="image">
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
        <!-- END User Profile -->

        <!-- Change Password -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Change Password') }}</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.users.change-password', $user->id) }}" method="POST" autocomplete="off">
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
