<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (isset($headerSubTitle))
        <title>Great Agent Intranet - {{$headerSubTitle}}</title>
    @else
        <title>Great Agent Intranet</title>
    @endif
    <meta name="csrf" content="{{ csrf_token() }}" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/default.css') }}" />
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('design')

</head>
<body>
@yield('content')
<script data-main="/ga/js/intranet" src="{{ asset('js/vendor/require.min.js') }}"></script>
</body>
</html>
