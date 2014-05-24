<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('head')

    <link rel="stylesheet" href="{{ asset('packages/lukaskorl/apigen/styles/main.min.css') }}">
    <script src="{{ asset('packages/lukaskorl/apigen/scripts/head.js') }}"></script>
</head>
<body class="@yield('body-class')">
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    @yield('body')

    <script src="{{ asset('packages/lukaskorl/apigen/scripts/vendor.js') }}"></script>
    <script src="{{ asset('packages/lukaskorl/apigen/scripts/core.js') }}"></script>
    <script>
    @yield('scripts')
    </script>
</body>
</html>
