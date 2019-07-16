@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col">
    <nav class="bg-gray-800 flex justify-center">
        <div class="container flex justify-between align-center py-5">
            <div>
                <h3 class="logo font-black text-xl flex items-center p-1">
                    <span class="fa-stack font-normal fa-3x mr-3" style="height: 60px; width: 60px;">
                        <i class="fas fa-circle fa-stack-1x leading-none" style="font-size: 95%"></i>
                        <i class="fab fa-reddit fa-stack-1x leading-none" style="color: #FF4500;"></i>
                    </span> Reddit Save Manager!
                    @auth
                    <br> Welcome @{{ user.get('username') }}
                    @endauth
                </h3>
            </div>
            <div>
                <a 
                    class="dropdown-item" 
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                >{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>


    <header class="flex justify-center bg-gray-700">
        <div class="container flex justify-between pt-20 py-5">
            <div class="flex-grow flex align-center">
                <input type="text" name="search" placeholder="Search..." class="w-1/3 rounded-full px-5 py-2 shadow-md outline-none mr-4 text-gray-700 border-2 border-transparent focus:border-orange-500" />
                <button class="outline-none focus:shadow-outline text-5xl focus:bg-blue-100 leading-none"><i class="fas fa-plus-circle color-blue-500"></i></button>
            </div>
            <div class="flex items-end">
                <button><i class="fas fa-filter text-3xl"></i></button>
            </div>
        </div>
    </header>


    <main class="flex justify-center bg-gray-900 flex-grow">
        <div class="container flex flex-col pb-5 pt-16">
            <h1 class="text-xl font-semibold mb-8">Reddit Saves</h1>
            <section class="cards flex flex-wrap justify-between items-stretch">
                <card
                    v-for="(save, index) in user.get('saves')"
                    :save="save.data"
                    :color="index % 3 == 0 ? 'bg-purple-gradient bg-purple-shadow' : index % 2 == 0 ? 'bg-yellow-gradient bg-yellow-shadow' : 'bg-blue-gradient bg-blue-shadow'"
                ></card>
            </section>
        </div>
    </main>
</div>

@endsection
