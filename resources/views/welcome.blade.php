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
    <nav class="flex justify-between items-center shadow fixed inset-x-0 z-10" style="background-color: hsla(0, 100%, 100%, 92%)">
        <div class="flex items-center px-2 md:px-6 py-3">
            <div class="mr-2" style="height: 50px; width: 50px;">
                <svg class="w-full h-full shadow-lg rounded-full" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="460" height="460" viewBox="0 0 460 460"><defs><clipPath id="a"><rect width="460" height="460" fill="none"/></clipPath><linearGradient id="b" x1="0.5" x2="0.5" y2="1.132" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#ff7d14"/><stop offset="1" stop-color="#ed041d"/></linearGradient><linearGradient id="c" y1="-7.618" y2="5.882" xlink:href="#b"/><clipPath id="d"><rect width="80" height="80" fill="none"/></clipPath><linearGradient id="e" y1="-3.353" y2="4.733" xlink:href="#b"/></defs><g clip-path="url(#a)"><circle cx="230" cy="230" r="230" fill="url(#b)"/><ellipse cx="161.5" cy="99" rx="161.5" ry="99" transform="translate(69 195.023)" fill="#fff"/><circle cx="37.5" cy="37.5" r="37.5" transform="translate(48 212.023)" fill="#fff"/><circle cx="37.5" cy="37.5" r="37.5" transform="translate(337 212.023)" fill="#fff"/><circle cx="30" cy="30" r="30" transform="translate(315 77.023)" fill="#fff"/><path d="M7393,576.181s92.437,100.634,185,0" transform="translate(-7255.005 -253.119)" fill="url(#c)"/><path d="M7436.5,453l22.28-132.023,69.72,21.048" transform="translate(-7206 -244.977)" fill="none" stroke="#fff" stroke-linejoin="round" stroke-width="20"/><g transform="translate(253 224.496)" clip-path="url(#d)"><path d="M7397.183,49.935l9.173,29.4h29.36l-23.685,18.184,9.222,29.625-24.07-18.321s-23.635,19.052-23.635,18.321,9.277-29.625,9.277-29.625L7358.8,79.337h29.286Z" transform="translate(-7357.25 -48.328)" fill="url(#e)"/></g><g transform="translate(128 224.496)" clip-path="url(#d)"><path d="M7397.183,49.935l9.173,29.4h29.36l-23.685,18.184,9.222,29.625-24.07-18.321s-23.635,19.052-23.635,18.321,9.277-29.625,9.277-29.625L7358.8,79.337h29.286Z" transform="translate(-7357.25 -48.328)" fill="url(#e)"/></g></g></svg>
            </div>
            <h2 class="text-gray-500 text-4xl font-display">RESAVMA</h2>
        </div>
        <div class="pr-12">
            <a 
                class="flex-grow-0 inline-flex text-lg py-2 px-4 text-white flex items-center bg-orange-600 hover:bg-orange-500 shadow-md hover:shadow tracking-wider rounded" 
                href="{{ route('reddit.redirect') }}"
            >
                <span class="font-bold text-shadow">Log In</span>
            </a>
        </div>
    </nav>

    <main class="hero bg-blue-gradient relative overflow-hidden">
        <div class="white-2"></div>
        <div class="container relative mx-auto px-2 px-6 flex flex-col justify-center h-screen">
            <h1 class="text-2xl leading-tight mb-12 w-full md:w-2/3 text-white text-shadow"><span class="font-display text-6xl leading-none">RESAVMA</span><br><br>Designed for you to save, manage and organize your saved posts and comments from Reddit <strong>without them disappearing</strong>.</h1>
            <div>
                <a 
                    class="flex-grow-0 inline-flex text-lg py-2 px-4 text-white flex items-center bg-dark-200 hover:bg-dark-300 shadow-md hover:shadow tracking-wider rounded" 
                    href="{{ route('reddit.redirect') }}"
                >
                    <i class="fab fa-reddit-alien text-3xl pr-3 text-white text-shadow"></i>
                    <span class="font-bold text-shadow">AUTHORIZE</span>
                </a>
            </div>
        </div>
    </main>
    <article class="pt-32 pb-16 container mx-auto">
        <div class="flex flex-wrap">
            <div class="w-full md:w-1/3 px-5 mb-16 flex flex-col items-center">
                <div class="text-4xl text-orange-500 w-16 py-1 bg-gray-300 rounded-full text-center">
                    <i class="leading-loose fas fa-bookmark"></i>
                </div>
                <h2 class="font-bold text-2xl text-orange-500 mb-2">Keep your saves</h2>
                <p class="text-center text-gray-700">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat, expedita necessitatibus nulla iure perferendis dolorum recusandae, quo amet nobis eos nisi unde libero modi sit quisquam quasi illum iste adipisci.</p>
            </div>
            <div class="w-full md:w-1/3 px-5 mb-16 flex flex-col items-center">
                <div class="text-4xl text-orange-500 w-16 py-1 bg-gray-300 rounded-full text-center">
                    <i class="leading-loose fas fa-pen"></i>
                </div>
                <h2 class="font-bold text-2xl text-orange-500 mb-2">Manage &amp; edit</h2>
                <p class="text-center text-gray-700">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat, expedita necessitatibus nulla iure perferendis dolorum recusandae, quo amet nobis eos nisi unde libero modi sit quisquam quasi illum iste adipisci.</p>
            </div>
            <div class="w-full md:w-1/3 px-5 mb-16 flex flex-col items-center">
                <div class="text-4xl text-orange-500 w-16 py-1 bg-gray-300 rounded-full text-center">
                    <i class="leading-loose fas fa-dollar-sign"></i>
                </div>
                <h2 class="font-bold text-2xl text-orange-500 mb-2">It's free</h2>
                <p class="text-center text-gray-700">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat, expedita necessitatibus nulla iure perferendis dolorum recusandae, quo amet nobis eos nisi unde libero modi sit quisquam quasi illum iste adipisci.</p>
            </div>
        </div>
    </article>
    <footer class="bg-blue-900 h-20">
  
    </footer>
</div>

</body>
</html>