@extends('admin.layouts.app')
@section('css')
    <style>
        /* Initially hide all card items and prepare for smooth transition */
        .card-item {
            display: none;
            /* Hidden by default */
            opacity: 0;
            /* Fully transparent */
            transform: translateY(20px);
            /* Slightly moved down */
            transition: all 0.4s ease;
            /* Smooth transition */
        }

        /* When card-item is shown, it fades in and moves up to its original position */
        .card-item.show {
            display: block;
            opacity: 1;
            /* Fully visible */
            transform: translateY(0);
            /* Move to original position */
        }
    </style>
@endsection
@section('js')
    <!-- Page JS Code -->
    @vite(['resources/js/pages/admin/languages.js'])
@endsection

@section('content')
    <!-- Hero -->
    @component('components.admin.breadcrumb-one', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'url' => route('admin.dashboard')],
            ['label' => __('Languages'), 'url' => route('admin.languages.index')],
            ['label' => $language->name],
        ],
    ])
        @slot('title')
            {{ $language->name }}
        @endslot
    @endcomponent
    <!-- END Hero -->
    <!-- Search -->
    <div class="content">
        <form action="be_pages_generic_search.html" method="POST">
            <div class="input-group">
                <input type="search" class="form-control" placeholder="Search.."
                    data-url="{{ route('admin.languages.search-words', $language->id) }}" id="search"
                    name="search">
                <span class="input-group-text">
                    <i class="fa fa-fw fa-search"></i>
                </span>
            </div>
        </form>
    </div>
    <!-- END Search -->
    <!-- Page Content -->
    <div class="content">
        <!-- All Languages -->
        <!-- All Words -->
        <div id="all-words" data-success-message="{{ __('Changes saved successfully.') }}"
            data-error-message="{{ __('An error occurred while saving changes.') }}">
            @include('admin.pages.languages.words', [
                'all_word' => $all_word,
                'language' => $language,
            ])
        </div>
        <div class="text-center mt-3 mb-3">
            <button id="show-more" class="btn btn-secondary">{{ __('Show More') }}</button>
        </div>
        <!-- /All Words -->

        <!-- END All Languages -->
    </div>
    <!-- END Page Content -->
@endsection
