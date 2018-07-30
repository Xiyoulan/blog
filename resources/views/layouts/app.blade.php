<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>@yield('title',config('app.name', 'Blog'))</title>  
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Styles -->
<!--        <link rel="stylesheet" href="{{ asset('css/style.css') }}" id="theme-styles">-->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Font-Awesome -->
        <link rel="stylesheet" href="{{ asset('css/font-awesome/font-awesome.min.css') }}">
        <!--[if lt IE 9]>      
            <script src="js/vendor/google/html5-3.6-respond-1.1.0.min.js"></script>
        <![endif]-->
        @yield('styles')
    </head>
    <body>
        <div id="app" class="{{ route_class() }}-page">
            @include('layouts._header')
            <div class="container"> @include('commons._message')</div>
            @yield('content')
            @include('layouts._footer') 
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
