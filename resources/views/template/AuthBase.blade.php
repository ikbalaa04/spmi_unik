<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $siteSettings['system_name'] ?: $siteSettings['campus_name'] }} - Login</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">


    <!-- Custom fonts for this template-->
    <link href="{{ asset('portal/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('portal/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('portal/css/spmi-admin.css') }}?v={{ filemtime(public_path('portal/css/spmi-admin.css')) }}"
        rel="stylesheet">

</head>

<body class="spmi-auth-page">

        @yield('auth')

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('portal/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('portal/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('portal/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('portal/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
