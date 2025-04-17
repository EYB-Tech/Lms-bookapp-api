<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
        <!-- Logo -->
        <a class="font-semibold text-dual" href="/">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-5 tracking-wider">{{ env('APP_NAME', 'Laravel') }}</span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div class="d-flex align-items-center gap-1">
            <!-- Dark Mode -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <div class="dropdown">
                <button type="button" class="btn btn-sm btn-alt-secondary" id="sidebar-dark-mode-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-fw fa-moon" data-dark-mode-icon></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end smini-hide border-0"
                    aria-labelledby="sidebar-dark-mode-dropdown">
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-toggle="layout"
                        data-action="dark_mode_off" data-dark-mode="off">
                        <i class="far fa-sun fa-fw opacity-50"></i>
                        <span class="fs-sm fw-medium">{{ __('Light') }}</span>
                    </button>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-toggle="layout"
                        data-action="dark_mode_on" data-dark-mode="on">
                        <i class="far fa-moon fa-fw opacity-50"></i>
                        <span class="fs-sm fw-medium">{{ __('Dark') }}</span>
                    </button>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-toggle="layout"
                        data-action="dark_mode_system" data-dark-mode="system">
                        <i class="fa fa-desktop fa-fw opacity-50"></i>
                        <span class="fs-sm fw-medium">{{ __('System') }}</span>
                    </button>
                </div>
            </div>
            <!-- END Dark Mode -->

            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="nav-main-link-icon si si-cursor"></i>
                        <span class="nav-main-link-name">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="nav-main-heading">{{ __('Pages') }}</li>
                @permission(['staffs_read', 'students_read'])
                    <li class="nav-main-item{{ request()->is('admin/users/*') ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="true" href="#">
                            <i class="nav-main-link-icon si si-users"></i>
                            <span class="nav-main-link-name">{{ __('Users') }}</span>
                        </a>
                        <ul class="nav-main-submenu">
                            @permission('staffs_read')
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs('admin.staffs.index') ? ' active' : '' }}"
                                        href="{{ route('admin.staffs.index') }}">
                                        <i class="nav-main-link-icon si si-user-following"></i>
                                        <span class="nav-main-link-name">{{ __('Staffs') }}</span>
                                    </a>
                                </li>
                            @endpermission
                            @permission('students_read')
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->routeIs('admin.students.index') ? ' active' : '' }}"
                                        href="{{ route('admin.students.index') }}">
                                        <i class="nav-main-link-icon si si-users"></i>
                                        <span class="nav-main-link-name">{{ __('Students') }}</span>
                                    </a>
                                </li>
                            @endpermission
                        </ul>
                    </li>
                @endpermission
                @permission('courses_read')
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->routeIs('admin.courses.index') ? ' active' : '' }}"
                            href="{{ route('admin.courses.index') }}">
                            <i class="nav-main-link-icon si si-rocket"></i>
                            <span class="nav-main-link-name">{{ __('Courses') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('tags_read')
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->routeIs('admin.tags.index') ? ' active' : '' }}"
                            href="{{ route('admin.tags.index') }}">
                            <i class="nav-main-link-icon si si-tag"></i>
                            <span class="nav-main-link-name">{{ __('Tags') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('subscriptions_read')
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->routeIs('admin.subscriptions.index') ? ' active' : '' }}"
                            href="{{ route('admin.subscriptions.index') }}">
                            <i class="nav-main-link-icon si si-feed"></i>
                            <span class="nav-main-link-name">{{ __('Subscriptions') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('uploads_read')
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->routeIs('admin.uploads.index') ? ' active' : '' }}"
                            href="{{ route('admin.uploads.index') }}">
                            <i class="nav-main-link-icon si si-cloud-upload"></i>
                            <span class="nav-main-link-name">{{ __('Uploads') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('settings_update')
                    <li class="nav-main-heading">{{ __('Site Settings') }}</li>
                    <li class="nav-main-item{{ request()->is('admin/website-setup/*') ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="true" href="#">
                            <i class="nav-main-link-icon si si-settings"></i>
                            <span class="nav-main-link-name">{{ __('Website setup') }}</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->routeIs('admin.settings.basic') ? ' active' : '' }}"
                                    href="{{ route('admin.settings.basic') }}">
                                    <span class="nav-main-link-name">{{ __('Basic') }}</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                    aria-expanded="false" href="#">
                                    <span class="nav-main-link-name">{{ __('Layouts') }}</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->routeIs('admin.settings.auth-layout') ? ' active' : '' }}"
                                            href="{{ route('admin.settings.auth-layout') }}">
                                            <span class="nav-main-link-name">{{ __('Auth layout') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->routeIs('admin.languages.index') ? ' active' : '' }}"
                            href="{{ route('admin.languages.index') }}">
                            <i class="nav-main-link-icon si si-globe"></i>
                            <span class="nav-main-link-name">{{ __('Languages') }}</span>
                        </a>
                    </li>
                @endpermission
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
