@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col">
    <nav class="bg-gray-800 flex justify-center">
        <div class="container flex justify-between align-center py-5">
            <div>
                <h3 
                    class="font-black text-xl flex items-center" 
                    onmouseover="this.innerHTML = '<i class=\'fab fa-reddit font-normal text-5xl mr-3\' style=\'color: #FF4500;\'></i> Reddit Save Manager!';" 
                    onmouseout="this.innerHTML = '<i class=\'fab fa-reddit font-normal text-5xl mr-3\' style=\'color: #FF4500;\'></i> RSM!';"
                    ><i class="fab fa-reddit font-normal text-5xl mr-3" style="color: #FF4500;"></i> RSM!</h3>
            </div>
            <div>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </nav>


    <header class="flex justify-center bg-gray-700">
        <div class="container flex justify-between pt-20 py-5">
            <div class="flex-grow flex align-center">
                <input type="text" name="search" placeholder="Search..." class="w-1/3 rounded-full px-5 py-2 bg-yellow-gradient shadow-md outline-none mr-4" />
                <button class="outline-none shadow-md text-3xl leading-none"><i class="fas fa-plus"></i></button>
            </div>
            <div class="flex items-end">
                <button><i class="fas fa-filter text-3xl"></i></button>
            </div>
        </div>
    </header>


    <main class="flex justify-center bg-gray-900 flex-grow">
        <div class="container flex flex-col pb-5 pt-16">
            <h1 class="text-xl font-semibold mb-8">Reddit Saves</h1>
            <section class="cards flex flex-wrap items-stretch -mx-3">
                <div class="card max-w-xs m-3 bg-yellow-gradient bg-yellow-shadow rounded-lg p-3">
                    <h2 class="text-4xl font-semibold" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">Card Title</h2>
                    <p class="text-xl opacity-75 mb-4" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);"><small>r/subreddit</small></p>
                    <p class="description text-md mb-16" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">This is where the notes will display</p>
                    <div class="tags flex flex-wrap">
                        <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 1</div>
                        <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 2</div>
                        <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 3</div>
                    </div>
                </div>

                <div class="card max-w-xs m-3 bg-blue-gradient bg-blue-shadow rounded-lg p-3">
                        <h2 class="text-4xl font-semibold" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">Card Title</h2>
                        <p class="text-xl opacity-75 mb-4" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);"><small>r/subreddit</small></p>
                        <p class="description text-md mb-16" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">This is where the notes will display</p>
                        <div class="tags flex flex-wrap">
                            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 1</div>
                            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 2</div>
                            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 3</div>
                        </div>
                    </div>

                    <div class="card max-w-xs m-3 bg-purple-gradient bg-purple-shadow rounded-lg p-3">
                            <h2 class="text-4xl font-semibold" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">Card Title</h2>
                            <p class="text-xl opacity-75 mb-4" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);"><small>r/subreddit</small></p>
                            <p class="description text-md mb-16" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">This is where the notes will display</p>
                            <div class="tags flex flex-wrap">
                                <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 1</div>
                                <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 2</div>
                                <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 3</div>
                            </div>
                        </div>
            </section>
        </div>
    </main>
</div>

@endsection
