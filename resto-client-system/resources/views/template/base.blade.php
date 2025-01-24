<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <base href="{{ asset('') }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="logo.png">

    <title>Resto Client</title>

    <link href="assets/node_modules/morrisjs/morris.css" rel="stylesheet">

    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="dist/css/pages/ui-bootstrap-page.css" rel="stylesheet">
    {{-- <link href="dist/css/pages/dashboard4.css" rel="stylesheet"> --}}

    @stack('css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue fixed-layout">
    <!-- Preload -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Cộng đoàn Đức Mẹ La Vang</p>
        </div>
    </div>

    <!-- Main wrapper -->
    @stack('wrapper')

    <!-- JS -->
    <script src="assets/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    @stack('js')
</body>

</html>
