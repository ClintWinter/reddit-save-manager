<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reddit Saves</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800|Expletus+Sans:500|Gruppo&display=swap&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="font-body">
        
<div id="app">
    <nav class="shadow fixed inset-x-0" style="background-color: hsla(0, 100%, 100%, 92%)">
        <div class="flex items-center px-2 md:px-6 py-3">
            <div class="mr-2" style="height: 50px; width: 50px;">
                @svg('Resavma-logo', 'w-full h-full shadow-lg rounded-full')
            </div>
            <h2 class="text-gray-500 text-4xl font-display">RESAVMA</h2>
        </div>
    </nav>

    <main class="bg-blue-gradient">
        <div class="container mx-auto px-2 px-6 flex flex-col justify-center h-screen">
            <h1 class="text-2xl leading-tight mb-12 w-full md:w-2/3 text-white text-shadow"><span class="font-display text-6xl leading-none">RESAVMA</span><br><br>Designed for you to save, manage and organize your saved posts and comments from Reddit <strong>without them disappearing</strong>.</h1>
            <div>
                <a 
                    class="flex-grow-0 inline-flex text-lg py-2 px-4 text-white bg-orange-400 hover:bg-orange-500 flex items-center shadow-md hover:shadow tracking-wider" 
                    href="{{ route('reddit.redirect') }}"
                >
                    <i class="fab fa-reddit-alien text-3xl pr-3 text-white text-shadow"></i>
                    <span class="font-bold text-shadow">AUTHORIZE</span>
                </a>
            </div>
        </div>
    </main>
</div>

</body>
</html>