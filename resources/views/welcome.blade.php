<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reddit Saves</title>

    <link href="https://fonts.googleapis.com/css?family=Blinker:400,700,900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-body">
        
<div class="container mx-auto p-4">
    <div id="app" style="max-width: 700px">
        <nav class="flex items-center">
            <div class="mr-2" style="height: 50px; width: 50px;">
                @svg('images/Resavma-logo.svg', 'w-full h-full shadow-lg rounded-full')
            </div>
            <h2 class="font-bold text-2xl">Resavma</h2>
        </nav>

        <h1 class="text-3xl mt-5 mb-20">Welcome to <strong>Reddit Save Manager!</strong></h1>

        <p class="text-lg leading-loose mb-8">Reddit Save Manager is designed for you to save, manage and organize your saved posts and comments from Reddit <strong>without them disappearing</strong>.</p>

        <a 
            class="inline-flex text-lg py-2 px-4 text-white bg-orange-500 hover:bg-orange-600 flex items-center shadow" 
            href="{{ route('reddit.redirect') }}"
            style="text-shadow: 1px 2px rgba(0,0,0,0.15)">
            <i class="fab fa-reddit-alien text-3xl pr-3" style="color: #FFFFFF;"></i>
            Login with Reddit!
        </a>
    </div>
</div>

</body>
</html>