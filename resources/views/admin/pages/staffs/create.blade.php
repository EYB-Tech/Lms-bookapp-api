@extends('admin.layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <form action="{{ route('admin.staffs.store') }}" method="POST"
        enctype="multipart/form-data" autocomplete="off">
            @csrf
            <!-- Info -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Info') }}</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <div class="mb-4">
                                <label class="form-label" for="name">{{ __('Name') }}</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="username">{{ __('Username') }}</label>
                                <input type="text" class="form-control" id="username" username="username"
                                    value="{{ old('username') }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">{{ __('Avatar') }}</label>
                                <div class="mb-4">
                                    <img class="img-avatar" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="avatar">
                                </div>
                                <div class="mb-4">
                                    <label for="one-profile-edit-avatar"
                                        class="form-label">{{ __('Choose a new avatar') }}</label>
                                    <input class="form-control" type="file" id="one-profile-edit-avatar" name="image">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    value="{{ old('password') }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="password_confirmation">{{ __('Confirmation password') }}</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" value="{{ old('password_confirmation') }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <button type="submit" class="btn btn-alt-primary" data-toggle="block-option"
                                data-action="state_toggle" data-action-mode="demo">{{ __('Create') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END Page Content -->
@endsection
