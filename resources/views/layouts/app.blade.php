<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Home | RESAVMA</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800|Expletus+Sans:500|Gruppo&display=swap&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    @livewireStyles
</head>
<body class="font-body">

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
    @livewireScipts
</body>
</html>
