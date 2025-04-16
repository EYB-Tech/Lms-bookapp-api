@extends('admin.layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <!-- Info -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Info') }}</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-form.base-input type="text" name="name" label="{{ __('Name') }}" />
                                </div>
                                <div class="col-lg-6">
                                    <x-form.base-input type="text" name="username" label="{{ __('Username') }}" />
                                </div>
                                <div class="col-lg-6">
                                    <x-form.base-input type="email" name="email" label="{{ __('Email') }}" />
                                </div>
                                <div class="col-lg-6">
                                    <x-form.base-input type="text" name="phone" label="{{ __('Phone') }}" />
                                </div>
                                <div class="col-lg-6">
                                    <x-form.base-input type="password" name="password" label="{{ __('Password') }}" />
                                </div>
                                <div class="col-lg-6">
                                    <x-form.base-input type="password" name="password_confirmation"
                                        label="{{ __('Confirmation Password') }}" />
                                </div>
                            </div>
                            <x-form.base-input type="file" name="image" label="{{ __('Choose a new avatar') }}" />
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
