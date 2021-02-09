<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RESAVMA</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
</head>
<body class="font-body bg-gradient-to-b from-gray-800 to-gray-900 text-gray-100">
    <header class="h-screen flex justify-center items-center">
        <div class="absolute w-full top-0 z-10">
            <div class="flex justify-between container mx-auto mt-8 px-2 md:px-12">
                <div class="text-2xl uppercase text-shadow-light-bg">Resavma</div>
            </div>
        </div>

        <div class="flex flex-col items-center z-10">
            <h1 class="text-5xl leading-tight text-center mb-12 text-shadow-light-bg w-full md:w-36rem">
                The Reddit save manager you've been wishing for.
            </h1>

            <a href="{{ route('reddit.redirect') }}" class="px-8 py-4 text-lg border-2 border-gray-100 shadow-md rounded-sm transition-colors hover:bg-gray-100 hover:text-gray-900 text-shadow-light-bg">
                Log in with Reddit
            </a>
        </div>

        <div class="absolute w-screen h-screen bg-yellow-gradient transform -skew-y-12 -translate-y-1/4"></div>
    </header>

    <section>
        <div class="container mx-auto py-16 px-2 md:px-12 flex flex-col items-center text-center">
            <h2 class="text-4xl leading-tight mb-6 w-full md:w-40rem">
                The most <span class="highlight"><span>feature-rich</span></span> Reddit save manager available.
            </h2>
            <p class="text-xl text-gray-300 leading-relaxed w-full md:w-40rem">
                Sync your saves. Apply filters. Full text search. Embedded images. Keyboard shortcuts. Designed with mobile and desktop in mind.
            </p>
        </div>
    </section>

    <section>
        <div class="container mx-auto py-16 px-2 md:px-12 flex flex-col items-center text-center">
            <h2 class="text-4xl leading-tight mb-6 w-full md:w-40rem">
                I'm a Reddit user too.
            </h2>
            <p class="text-xl text-gray-300 leading-relaxed w-full md:w-40rem">
                This project was born out of my own frustrations with the limitations of the save feature. I use Resavma. I want it to be the best it can be for all of us.
            </p>
        </div>
    </section>

    <section>
        <div class="container mx-auto py-16 px-2 md:px-12 flex flex-col items-center text-center">
            <h2 class="text-4xl leading-tight mb-6 w-full md:w-40rem">
                Did you know your saves are limited?
            </h2>
            <p class="text-gray-300 text-xl leading-relaxed w-full md:w-40rem">
                <b><em>Reddit limits your saves to 1,000</em></b>. After that, any new content you save pushes off the oldest one into the abyss, never to be remembered again. Resavma will keep a record of all of your saves, even if Reddit won't.
            </p>
        </div>
    </section>

    <section>
        <div class="container mx-auto py-16 px-2 md:px-12 flex flex-col items-center text-center">
            <h2 class="text-4xl leading-tight mb-6 w-full md:w-40rem">
                <span class="highlight"><span>Actively maintained</span></span> with more features planned.
            </h2>
            <p class="mb-4 text-gray-300 text-xl leading-relaxed w-full md:w-40rem">
                I'm manually typing this date of <b>February 9, 2021</b> to let you know that I am actively maintaining this project. This won't be an old, slow, outdated project. I want to make this the ideal solution for you. Please reach out to me at <a class="underline" href="mailto:clint.resavma@gmail.com">clint.resavma@gmail.com</a> to request a feature!
            </p>
            <p class="text-xl leading-tight text-gray-500 w-full md:w-40rem">
                <b>Upcoming features</b>: Export your saves. Light/Dark mode. Full profile page with settings. Tagging. Advanced filters. Public &amp; private galleries. Gallery sharing &amp; discovering. Gallery saving &amp; collecting. Gallery cloning &amp; modification. <span class="text-gray-300">And more!</span>
            </p>
        </div>
    </section>

    <footer id="landing-footer" class="bg-gray-900 shadow-inner">
        <div class="container mx-auto py-20 px-2 md:px-12">
            <p class="mb-4 text-xl text-gray-100">Sign up to stay in the loop on new features!</p>
            <form class="flex border-2 border-gray-800 rounded" action="/subscribe" method="POST">
                @csrf
                <input type="email" class="text-gray-900 flex-grow rounded-l-sm p-6 text-lg focus:outline-none" name="email" placeholder="your-email@example.com" value="{{ old('email') }}">
                <button id="subscribe" class="bg-purple-gradient hover:bg-gray-700 text-white rounded-r-sm px-6 md:px-12 p-6 text-lg focus:outline-none">Subscribe</button>
            </form>
            <p id="subscribe-error" class="hidden mt-4 text-red-400 font-semibold text-lg">Looks like you are already subscribed!</p>
            <p id="subscribe-status" class="hidden mt-4 text-green-400 font-semibold text-lg">{{ session('subscribed') }}</p>

            <div class="mt-16 text-gray-500">
                {{-- <p>Winter Web Works LLC</p> --}}
                <p>&copy; 2021. Resavma.com All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="/js/welcome.js"></script>
</body>
</html>
