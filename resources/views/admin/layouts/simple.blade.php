<!doctype html>
<html lang="{{ config('app.locale') }}" dir="{{ get_lang_dir() }}">

<head>
    <meta charset="utf-8">
    <!--
    Available classes for <html> element:

    'dark'                  Enable dark mode - Default dark mode preference can be set in app.js file (always saved and retrieved in localStorage afterwards):
                              window.One = new App({ darkMode: "system" }); // "on" or "off" or "system"
    'dark-custom-defined'   Dark mode is always set based on the preference in app.js file (no localStorage is used)
  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ env('APP_NAME', 'Laravel') }}</title>

    <meta name="author" content="EYB Tech" />
	<meta name="keywords" content="{{ get_setting('site_description') }}"/>
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
    @endif
    <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
    {{-- @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/amethyst.scss', 'resources/js/oneui/app.js']) --}}
    <style>
        body {
                -webkit-user-select: none;
                /* Disable text selection */
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
    </style>
    <!-- Load and set dark mode preference (blocking script to prevent flashing) -->
    <script src="{{ asset('js/setTheme.js') }}"></script>
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
    <div id="page-container">
        <!-- Main Container -->
        <main id="main-container">
            @yield('content')
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
</body>

</html>
