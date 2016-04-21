<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if ($title = (isset($headerTitle) ? $headerTitle : 'Great Agent USA' ))
        @if (isset($headerSubTitle))
            <title>$title - {{$headerSubTitle}}</title>
        @else
            <title>{{$title}}</title>
        @endif
    @else
        <title>Great Agent - USA</title>
    @endif
    
    <meta name="csrf" content="{{ csrf_token() }}" />

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="http://greatagentusa.com/xmlrpc.php">
    <link rel="canonical" href="http://greatagentusa.com/login/" />

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Great Agent USA" />
    <meta property="og:description" content="The Fastest Growing Real Estate Platform">
    <meta property="og:url" content="http://greatagentusa.com/login/" />
    <meta property="og:site_name" content="Great Agent USA" />
    <meta property="og:image" content="">
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="Great Agent USA"/>
    <meta name="twitter:domain" content="Great Agent USA"/>
    <link rel="alternate" type="application/rss+xml" title="Great Agent USA &raquo; Feed" href="http://greatagentusa.com/feed/" />
    <link rel="alternate" type="application/rss+xml" title="Great Agent USA &raquo; Comments Feed" href="http://greatagentusa.com/comments/feed/" />
    <link rel="alternate" type="application/rss+xml" title="Great Agent USA &raquo;" href="http://greatagentusa.com/login/" />

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
@include('widgets.default-header')
@yield('content')
@include('widgets.default-footer')
<script data-main="/ga/js/default" src="{{ asset('js/vendor/require.min.js') }}"></script>
</body>
</html>
