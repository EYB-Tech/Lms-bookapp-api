@extends('admin.layouts.app')
@section('js')
    <script>
        $(function() {
            $("body").on("change", ".check-model", function() {
                let modelName = $(this).val();
                if ($(this).prop("checked")) {
                    $('.' + modelName).each(function(index) {
                        $(this).prop("checked", true);
                    });
                } else {
                    $('.' + modelName).each(function(index) {
                        $(this).prop("checked", false);
                    });
                }
            }); //end of inputs check box change
        });
    </script>
@endsection
@section('content')
    <!-- Hero -->
    <div class="bg-image" style="background-image: url('{{ asset('media/photos/photo10@2x.jpg') }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center">
                <div class="my-3">
                    <img class="img-avatar img-avatar-thumb" src="{{ getAvatar($user->image) }}" alt="{{ $user->name }}">
                </div>
                <h1 class="h2 text-white mb-0">{{ $user->name }}</h1>
                <h2 class="h4 fw-normal text-white-75">
                    {{ __('Staff') }}
                </h2>
                @if (auth()->user()->hasRole('super_admin'))
                    <a class="btn btn-alt-secondary" href="{{ route('admin.users.impersonate', $user->id) }}"
                        data-bs-toggle="tooltip" title="{{ __('Impersonate') }}">
                        <i class="fa fa-fw fa-user-secret text-info"></i> {{ __('Impersonate') }}
                    </a>
                @endif
                @permission('staffs_delete')
                    <a class="btn btn-alt-secondary" href="javascript:void(0)"
                        onclick="event.preventDefault(); 
            if (confirm('Are you sure?')) {
                document.getElementById('delete-form-{{ $user->id }}').submit();
            }"
                        data-bs-toggle="tooltip" title="{{ __('Remove') }}">
                        <i class="fa fa-fw fa-times text-danger"></i> {{ __('Remove') }}
                    </a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" id="delete-form-{{ $user->id }}"
                        method="post" style="display: none">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                    </form>
                @endpermission
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
                                <label class="form-label" for="username">{{ __('Username') }}</label>
                                <input type="text" class="form-control" id="username" username="username"
                                    placeholder="Enter your username.." value="{{ $user->username }}">
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

        <!-- Change Permissions -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Change Permissions') }}</h3>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.users.update-permissions', $user->id) }}" method="POST"
                    autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="row push">
                        <div class="col-12">
                            <div class="row mb-4">
                                <div class="col-12">
                                    @php
                                        $models = Config::get('laratrust_seeder.staff_modules');
                                        $permissions_map = Config::get('laratrust_seeder.permissions_map');
                                    @endphp
                                    @foreach ($models as $model => $permissions)
                                        <div class="form-check form-check-inline my-2">
                                            <input class="form-check-input check-model" type="checkbox"
                                                id="{{ $model }}" value="{{ $model }}">
                                            <label class="form-check-label fw-bold" for="{{ $model }}">
                                                {{ __(ucwords($model)) }}
                                            </label>
                                        </div>
                                        <div class="row">
                                            @foreach (explode(',', $permissions) as $index => $map)
                                                @php
                                                    $permission = $permissions_map[$map];
                                                @endphp
                                                {{-- @if (strstr($permission->name, $model)) --}}
                                                <div class="col-sm-4 col-md-3 col-lg-2 col-6 mx-auto">
                                                    <div class="form-check form-check-inline my-2">
                                                        <input class="form-check-input {{ $model }}"
                                                            type="checkbox" name="permissions[]"
                                                            id="{{ $model . '_' . $permission }}"
                                                            @checked($user->hasPermission($model . '_' . $permission))
                                                            value="{{ $model . '_' . $permission }}">
                                                        <label class="form-check-label"
                                                            for="{{ $model . '_' . $permission }}">
                                                            {{ __(ucwords($permission)) }} {{ __(ucwords($model)) }}
                                                        </label>
                                                    </div>
                                                </div>
                                                {{-- @endif --}}
                                            @endforeach
                                        </div>
                                    @endforeach
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
        <!-- END Change Permissions -->
    </div>
    <!-- END Page Content -->
@endsection
