<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--
    Available classes for <html> element:

    'dark'                  Enable dark mode - Default dark mode preference can be set in app.js file (always saved and retrieved in localStorage afterwards):
                              window.One = new App({ darkMode: "system" }); // "on" or "off" or "system"
    'dark-custom-defined'   Dark mode is always set based on the preference in app.js file (no localStorage is used)
  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ env('APP_NAME', 'Laravel') . ' - ' . __('Dashboard') }}</title>

    <meta name="author" content="EYB Tech" />
    <meta name="keywords" content="{{ get_setting('site_description') }}" />
    <meta name="description" content="{{ get_setting('site_description') }}" />
    <meta name="robots" content="index, follow">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ uploaded_asset(get_setting('site_favicon')) }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ uploaded_asset(get_setting('site_favicon')) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ uploaded_asset(get_setting('site_favicon')) }}">
    <!-- Modules -->
    @yield('css')
    @php
        if (!get_setting('site_theme') || get_setting('site_theme') == 'default') {
            $theme = '_base';
        } else {
            $theme = get_setting('site_theme');
        }
    @endphp
    @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/' . $theme . '.scss', 'resources/js/oneui/app.js'])
    @if (get_lang_dir() == 'rtl')
        <link rel="stylesheet" href="{{ asset('js/bootstrap-utilities.rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('js/bootstrap-inputs.rtl.css') }}">
    @endif
    @if (app()->environment('production'))
        <style>
            body {
                -webkit-user-select: none;
                /* Disable text selection */
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
        </style>
    @endif

    <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
    {{-- @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/amethyst.scss']) --}}

    <!-- Load and set dark mode preference (blocking script to prevent flashing) -->
    <script src="{{ asset('js/setTheme.js') }}"></script>
    <!-- jQuery (required for Magnific Popup plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    @if ($errors->any())
        <!-- Page JS Helpers (BS Notify Plugin) -->
        @foreach ($errors->all() as $error)
            <script type="module">
                One.helpers('jq-notify', {
                    type: 'danger',
                    icon: 'fa fa-times me-1',
                    message: '{{ $error }}'
                });
            </script>
        @endforeach
    @endif
    @php
        $alertTypes = [
            'success' => ['type' => 'success', 'icon' => 'fa fa-check me-1'],
            'error' => ['type' => 'danger', 'icon' => 'fa fa-times me-1'],
            'warning' => ['type' => 'warning', 'icon' => 'fa fa-exclamation me-1'],
            'info' => ['type' => 'info', 'icon' => 'fa fa-info me-1'],
        ];
    @endphp

    @foreach ($alertTypes as $key => $config)
        @if (session($key))
            <script type="module">
                One.helpers('jq-notify', {
                    type: '{{ $config['type'] }}',
                    icon: '{{ $config['icon'] }}',
                    message: '{{ session($key) }}'
                });
            </script>
        @endif
    @endforeach
    <script type="module">
        One.loader('show');
        // script.js
        window.onload = function() {
            // Simulate a delay (like fetching data)
            setTimeout(function() {
                One.loader('hide')
            }, 500); // 0.5 seconds delay to show loader for demo purposes
        };
    </script>

    @yield('js')

    @if (app()->environment('production'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_ID') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ env('GOOGLE_ANALYTICS_ID') }}');
        </script>
        @vite(['resources/js/scripts.js'])
    @endif
</head>

<body>
    <!-- Page Container -->
    <!--
    Available classes for #page-container:

    SIDEBAR and SIDE OVERLAY

      'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
      'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
      'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
      'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
      'sidebar-dark'                              Dark themed sidebar

      'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
      'side-overlay-o'                            Visible Side Overlay by default

      'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

      'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

    HEADER

      ''                                          Static Header if no class is added
      'page-header-fixed'                         Fixed Header

    HEADER STYLE

      ''                                          Light themed Header
      'page-header-dark'                          Dark themed Header

    MAIN CONTENT LAYOUT

      ''                                          Full width Main Content if no class is added
      'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
      'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
  -->
    @if (get_lang_dir() == 'rtl')
        <div id="page-container"
            class="sidebar-o sidebar-dark enable-page-overlay sidebar-r side-scroll page-header-fixed main-content-narrow rtl-support">
        @else
            <div id="page-container"
                class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
    @endif

    <div id="page-loader" class="show"></div>
    <!-- Sidebar -->
    <!--
        Sidebar Mini Mode - Display Helper classes

        Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
            If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

        Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
        Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
        -->
    @include('admin.layouts.partials.sidebar')
    <!-- END Sidebar -->

    <!-- Header -->
    @include('admin.layouts.partials.header')
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        @yield('content')
        @component('components.modal-selection-images')
        @endcomponent
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    @include('admin.layouts.partials.footer')
    <!-- END Footer -->
    </div>
    <!-- END Page Container -->
</body>

</html>
