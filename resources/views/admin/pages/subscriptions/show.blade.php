@extends('admin.layouts.app')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="item item-circle bg-success-light mx-auto">
                            <i class="fa fa-check text-success"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-success mb-0">
                            Sub.{{ $subscription->id }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="item item-circle bg-success-light mx-auto">
                            <i class="fa fa-check text-success"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-success mb-0">
                            {{ $subscription->transaction_id ? 'Trs.' . $subscription->transaction_id : 'No transaction ID' }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        @if ($subscription->payment_status == 'Paid')
                            <div class="item item-circle bg-success-light mx-auto">
                                <i class="fa fa-check text-success"></i>
                            </div>
                        @elseIf($subscription->payment_status == 'Failed')
                            <div class="item item-circle bg-danger-light mx-auto">
                                <i class="fa fa-check text-danger"></i>
                            </div>
                        @else
                            <div class="item item-circle bg-secondary-light mx-auto">
                                <i class="fa fa-sync fa-spin text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        @if ($subscription->payment_status == 'Paid')
                            <p class="fw-medium fs-sm text-success mb-0">
                                {{ __('Paid') }}
                            </p>
                        @elseIf($subscription->payment_status == 'Failed')
                            <p class="fw-medium fs-sm text-danger mb-0">
                                {{ __('Failed') }}
                            </p>
                        @else
                            <p class="fw-medium fs-sm text-secondary mb-0">
                                {{ __('Pending') }}
                            </p>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center modal-edit" data-bs-toggle="modal"
                    data-bs-target="#edit-modal" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="item item-circle bg-body mx-auto">
                            <i class="fa fa-edit text-muted"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            {{ __('Edit') }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

        <!-- Subscription -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Subscription') }}</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter fs-sm">
                        <thead>
                            <tr>
                                <th>{{ __('Course') }}</th>
                                <th class="text-center">{{ __('Start') }}</th>
                                <th class="text-end" style="width: 10%;">{{ __('Expiration') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a
                                        href="{{ route('admin.courses.show', $course->id) }}"><strong>{{ __($course?->name) }}</strong></a>
                                </td>
                                <td class="text-center">
                                    {{ $subscription->start_date }}
                                </td>
                                <td class="text-end">{{ $subscription->end_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END Subscription -->

        <!-- Student -->
        <div class="row">
            <div class="col-md-6">
                <!-- Student-->
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Student') }}</h3>
                    </div>
                    <div class="block-content">
                        @if ($student->image)
                            <img class="img-avatar img-avatar-thumb" src="{{ getImage($student->image) }}"
                                alt="{{ $student->name }}">
                        @else
                            <img class="img-avatar img-avatar-thumb" src="{{ asset('media/avatars/avatar10.jpg') }}"
                                alt="{{ $student->name }}">
                        @endif
                        <div class="fs-4 mb-1">{{ $student->name }}</div>
                        <address class="fs-sm">
                            <i class="fa fa-phone"></i> {{ $student->phone }}<br>
                            <a href="{{ route('admin.students.show', $student->id) }}">{{ $student->email }}</a>
                        </address>
                    </div>
                </div>
                <!-- END Student-->
            </div>
        </div>
        <!-- END Student -->
        @if ($student->subscriptions)
            <!-- Log Subscriptions -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('Last') }} {{ __('Subscriptions') }}</h3>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-striped table-vcenter fs-sm">
                        <tbody>
                            @foreach ($student->subscriptions()->latest()->get() as $sub)
                                <tr>
                                    <td style="width: 220px;">
                                        <span class="fw-semibold">{{ $sub->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('admin.subscriptions.show', $sub->id) }}">Sub.{{ $sub->id }}</a>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('admin.courses.show', $course->id) }}">{{ $course->name }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Log Subscriptions -->
        @endif
        <!-- Edit Subscription Modal -->
        @include('admin.pages.subscriptions.edit-subscription-model')
        <!-- END Edit Subscription Modal -->
    </div>
    <!-- END Page Content -->
@endsection
