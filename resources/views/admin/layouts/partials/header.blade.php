<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
            <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout"
                data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- END Toggle Sidebar -->
            <!-- Mega Menu -->
            <nav class="d-none d-lg-flex align-items-center ms-2">
                <a class="btn btn-sm btn-alt-secondary ms-2" href="{{ route('home') }}">
                    <i class="fa fa-home opacity-50 me-1"></i>
                    <span>{{ __('Landing') }}</span>
                </a>
                <a class="btn btn-sm btn-alt-secondary ms-2" href="{{ route('cache') }}">
                    <i class="fa fa-refresh opacity-50 me-1"></i>
                    <span>Cache</span>
                </a>
                <div class="dropdown ms-2">
                    <button class="btn btn-sm btn-alt-secondary" type="button" id="page-header-change-lang"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-globe-americas opacity-50 me-1"></i>
                        <span> {{ __('Lang') }}</span>
                        <i class="fa fa-fw fa-angle-down opacity-50"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu dropdown-menu-mega p-0 border-0"
                        aria-labelledby="page-header-change-lang">
                        @foreach (all_active_language() as $language)
                            <a rel="alternate" hreflang="{{ $language->slug }}"
                                class="dropdown-item {{ App::currentLocale() == $language->slug ? 'active' : '' }}"
                                href="{{ LaravelLocalization::getLocalizedURL($language->slug, null, [], true) }}">
                                {{ $language->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
            </nav>
            <!-- END Mega Menu -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
            <!-- User Dropdown -->
            <div class="dropdown d-inline-block ms-2">
                <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="rounded-circle" src="{{ getAvatar(Auth::user()->image) }}" alt="{{Auth::user()->name}}"
                        style="width: 21px;">
                    <span class="d-none d-sm-inline-block ms-2">{{ explode(' ', Auth::user()->name)[0] }}</span>
                    <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1 mt-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                    aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                        <img class="img-avatar img-avatar48 img-avatar-thumb"
                            src="{{ getAvatar(Auth::user()->image) }}" alt="{{Auth::user()->name}}">
                        <p class="mt-2 mb-0 fw-medium">{{ Auth::user()->name }}</p>
                        <p class="mb-0 text-muted fs-sm fw-medium">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route('admin.profile') }}">
                            <span class="fs-sm fw-medium">{{ __('Profile') }}</span>
                            {{-- <span class="badge rounded-pill bg-primary ms-2">1</span> --}}
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="{{ route('admin.settings.basic') }}">
                            <span class="fs-sm fw-medium">{{ __('Settings') }}</span>
                        </a>
                    </div>
                    <div role="separator" class="dropdown-divider m-0"></div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                            href="javascript:void(0)"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form-header').submit();">
                            <span class="fs-sm fw-medium">{{ __('Log Out') }}</span>
                        </a>
                        <form id="logout-form-header" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <!-- END User Dropdown -->

            <!-- Notifications Dropdown -->
            <div class="dropdown d-inline-block ms-2">
                <button type="button" class="btn btn-sm btn-alt-secondary"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <span class="text-primary">•</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 border-0 fs-sm"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-2 bg-body-light border-bottom text-center rounded-top">
                        <h5 class="dropdown-header text-uppercase">{{ __('Notifications') }}</h5>
                    </div>
                    <ul class="nav-items mb-0">
                        @foreach (auth()->user()->unreadNotifications as $notification)
                            <li>
                                <a class="text-dark d-flex py-2" href="{{ $notification->data['link'] }}">
                                    <div class="flex-shrink-0 me-2 ms-3">
                                        <i class="fa fa-fw fa-check-circle text-success"></i>
                                    </div>
                                    <div class="flex-grow-1 pe-2">
                                        <div class="fw-semibold">{{ $notification->data['subject'] }}</div>
                                        <span
                                            class="fw-medium text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <div class="p-2 border-top text-center">
                            <a class="d-inline-block fw-medium" href="{{ route('mark-as-read') }}">
                                <i class="fa fa-fw fa-check me-1 opacity-50"></i> {{ __('Mark read all') }}
                            </a>
                        </div>
                    @else
                        <div class="p-2 border-top text-center">
                            {{ __('Notifications are empty') }}
                        </div>
                    @endif
                </div>
            </div>
            <!-- END Notifications Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Loader -->
    <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-body-extra-light">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-circle-notch fa-spin"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>