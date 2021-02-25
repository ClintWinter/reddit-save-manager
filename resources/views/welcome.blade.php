<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RESAVMA</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500&family=Pacifico&display=swap" rel="stylesheet">

    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
</head>
<body class="font-body bg-main-dark">
    <header class="h-screen text-white">
        <div class="container mx-auto mb-40">
            <div class="flex justify-between mt-8 px-2 md:px-12">
                <div class="text-2xl uppercase font-bold">Resavma</div>
            </div>
        </div>

        <div class="container mx-auto px-2 md:px-12">
            <h1 class="mb-4 w-full md:w-48rem text-5xl leading-tight font-black">
                The Reddit save manager you've been wishing for.
            </h1>

            <p class="mb-16 text-xl text-main-light opacity-75">
                Organize all of your most precious content without losing it.
            </p>

            <a href="{{ route('reddit.redirect') }}" class="inline-block px-8 py-4 text-lg bg-main-blue text-white font-bold rounded-sm">
                Log in with Reddit
            </a>
        </div>
    </header>

    <section>
        <div class="container mx-auto py-16 px-2 md:px-12">
            <h2 class="text-4xl leading-tight mb-6 w-full md:w-40rem font-black text-white">
                The most <span class="font-display text-main-teal">feature-rich</span> Reddit save manager available.
            </h2>
            <p class="w-full md:w-40rem leading-relaxed text-xl text-white">
                Sync your saves. Apply filters. Full text search. Embedded images. Keyboard shortcuts. Designed with mobile and desktop in mind.
            </p>
        </div>
    </section>

    <section>
        <div class="container mx-auto py-16 px-2 md:px-12">
            <h2 class="text-4xl leading-tight mb-6 w-full md:w-40rem font-black text-white">
                I'm a Reddit user too.
            </h2>
            <p class="text-xl leading-relaxed w-full md:w-40rem text-white">
                This project was born out of my own frustrations with the limitations of the save feature. I use Resavma. I want it to be the best it can be for all of us.
            </p>
        </div>
    </section>

    <section>
        <div class="container mx-auto py-16 px-2 md:px-12">
            <h2 class="text-4xl leading-tight mb-6 w-full md:w-40rem font-black text-white">
                Did you know your saves are limited?
            </h2>
            <p class="text-xl leading-relaxed w-full md:w-40rem text-white">
                <b><em>Reddit limits your saves to 1,000</em></b>. After that, any new content you save pushes off the oldest one into the abyss, never to be remembered again. Resavma will keep a record of all of your saves, even if Reddit won't.
            </p>
        </div>
    </section>

    <section>
        <div class="container mx-auto py-16 px-2 md:px-12">
            <h2 class="text-4xl leading-tight mb-6 w-full md:w-40rem font-black text-white">
                <span class="font-display text-main-teal">Actively maintained</span> with more features planned.
            </h2>
            <p class="mb-8 text-white text-xl leading-relaxed w-full md:w-40rem">
                I'm manually typing this date of <b>February 25, 2021</b> to let you know that I am actively maintaining this project. This won't be an old, slow, outdated project. I want to make this the ideal solution for you. Please reach out to me at <a class="underline" href="mailto:clint.resavma@gmail.com">clint.resavma@gmail.com</a> to request a feature!
            </p>
            <p class="leading-tight text-white opacity-50 w-full md:w-40rem">
                <b>Upcoming features</b>: Export your saves. Light/Dark mode. Full profile page with settings. Tagging. Advanced filters. Public &amp; private galleries. Gallery sharing &amp; discovering. Gallery saving &amp; collecting. Gallery cloning &amp; modification.And more!
            </p>
        </div>
    </section>

    <section class="bg-main-blue">
        <div class="container mx-auto py-16 px-2 md:px-12 flex justify-between">
            <div class="text-center lg:text-left w-full lg:w-96 m-0 lg:mr-8 flex-none">
                <h2 class="text-4xl leading-tight mb-6 w-full text-white font-black">Use it the way that works best for you.</h2>
                <p class="mb-4 text-white text-xl leading-relaxed w-full">
                    Making enough money to make this project worthwhile is an important part of delivering something great. That being said, I want the pricing to be extremely reasonable.
                </p>
            </div>

            <div class="w-full md:w-40rem flex flex-col sm:flex-row flex-grow -mx-4">
                <div class="flex-grow sm:w-1/2 m-2 p-4 bg-main-blue-dark rounded-sm">
                    <div class="mb-1 text-white text-4xl font-bold">Free</div>
                    <div class="mb-6 text-lg uppercase tracking-wide text-main-teal font-medium">Basic</div>
                    <div class="text-lg text-white">
                        <ul class="leading-loose">
                            <li>Filter</li>
                            <li>Sort</li>
                            <li>Sync</li>
                            <li>Galleries</li>
                        </ul>
                    </div>
                </div>

                <div class="flex-grow sm:w-1/2 m-2 p-4 bg-main-blue-dark border-4 border-main-teal rounded-sm">
                    <div class="inline-block mb-8 text-sm bg-main-teal text-white font-bold rounded-lg px-2 py-1">Recommended</div>
                    <div class="mb-1 text-white text-4xl font-bold">$22/year</div>
                    <div class="mb-6 text-lg tracking-wide text-main-teal font-medium"><span class="uppercase">Premium</span> <span class="font-display text-yellow-400 text-xs">Limited time</span></div>
                    <div class="text-lg text-white">
                        <ul class="leading-loose">
                            <li>Ad-free</li>
                            <li>Advanced Filters</li>
                            <li>Advanced Galleries</li>
                            <li class="opacity-50">In addition to all Basic Plan features</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="landing-footer" class="">
        <div class="container mx-auto pt-10 pb-20 md:py-20 px-2 md:px-12">
            <p class="mb-4 text-xl text-white w-full md:w-40rem">
                Sign up for updates on major feature releases and to be notified when the Premium subscription plan becomes available.
            </p>
            <form class="flex rounded shadow-md" action="/subscribe" method="POST">
                @csrf
                <input type="email" class="text-gray-900 flex-grow rounded-l-sm p-6 text-lg focus:outline-none" name="email" placeholder="your-email@example.com" value="{{ old('email') }}">
                <button id="subscribe" class="bg-main-blue text-white font-bold rounded-r-sm px-6 md:px-12 p-6 text-lg focus:outline-none">Subscribe</button>
            </form>
            <p id="subscribe-error" class="hidden mt-4 text-red-400 font-semibold text-lg">Looks like you are already subscribed!</p>
            <p id="subscribe-status" class="hidden mt-4 text-green-400 font-semibold text-lg">{{ session('subscribed') }}</p>

            <div class="mt-8">
                {{-- <p>Winter Web Works LLC</p> --}}
                <p class="text-white opacity-50">&copy; 2021. Resavma.com All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="/js/welcome.js"></script>
</body>
</html>
