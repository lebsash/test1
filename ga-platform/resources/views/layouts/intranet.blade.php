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
    <link rel="stylesheet" href="{{ asset('css/intranet.css') }}" />
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('design')

</head>
<body>
@include('widgets.intranet-header')
<div class="row page-content">
    <div class="col-md-8  col-centered">
        @yield('content')
    </div>
</div>
@include('widgets.intranet-footer')
<script data-main="/js/intranet" src="{{ asset('js/vendor/require.min.js') }}"></script>
</body>
</html>
