@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col">
    <nav class="bg-gray-800 flex justify-center">
        <div class="w-full flex justify-between items-center py-2 px-4">
            <div>
                <h3 class="logo font-black text-xl flex items-center p-1">
                    <span class="fa-stack font-normal fa-3x mr-3" style="height: 60px; width: 60px;">
                        <i class="fas fa-circle fa-stack-1x leading-none" style="font-size: 95%"></i>
                        <i class="fab fa-reddit fa-stack-1x leading-none" style="color: #FF4500;"></i>
                    </span> Reddit Save Manager!
                </h3>
            </div>
            <div>
                <a href="#">@{{ user.name }}</a>
                {{-- <a 
                    class="dropdown-item" 
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                >{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form> --}}
            </div>
        </div>
    </nav>

    <section 
        id="modal" 
        class="fixed inset-0 flex justify-center items-center z-10" 
        v-show="showFilters">
            <div @click="showFilters = false" class="absolute inset-0 bg-black opacity-50"></div>
            <div class="z-20 bg-white shadow-xl rounded text-black p-2">
                <div class="flex justify-between items-center mb-10 leading-none">
                    <h4 class="text-gray-700 font-bold text-xl">Filters</h4>
                    <button @click="showFilters = false" class="text-gray-500 hover:text-gray-700 text-4xl">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                
                <div class="p-5">
                    <div class="flex justify-between items-center">
                        <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Subreddit</label>
                        <select id="subreddit" class="w-64 block h-8 my-4">
                            <option>Something</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center">
                        <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Tag</label>
                        <select id="subreddit" class="w-64 block h-8 my-4">
                            <option>Something</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center">
                        <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Type</label>
                        <select id="subreddit" class="w-64 block h-8 my-4">
                            <option>Something</option>
                        </select>
                    </div>
                </div>
            </div>
    </section>

    <header class="flex justify-center bg-gray-700">
        <div class="w-full flex justify-between py-2 px-4">
            <div class="flex-grow flex align-center">
                <input 
                    v-model="query" 
                    @keyup.enter="filterResults" 
                    type="text" 
                    name="query" 
                    placeholder="Search..." 
                    class="w-1/3 rounded-full px-5 py-2 shadow-lg outline-none mr-4 text-gray-700 border-2 border-transparent focus:border-orange-500" />
            </div>
            <div class="flex items-center">
                <button 
                    class="bg-white text-black px-4 py-2 rounded shadow-lg hover:bg-orange-500 hover:text-white"
                    @click="showFilters = true">
                    <i 
                    class="fas fa-filter text-3xl"></i>
                </button>
            </div>
        </div>
    </header>


    <main class="flex justify-center bg-gray-900 flex-grow">
        <div class="w-full flex flex-col px-4 pt-8 pb-40">
            <pagination 
                @pageclick="goToPage"
                @countchange="updateCount"
                v-show="pagination.from"
                :pagination="pagination"
                :processing="isProcessing"></pagination>
            <section class="cards flex flex-wrap justify-start items-stretch">
                <card v-for="(save, index) in saves" :save="save"></card>
            </section>
            <pagination 
                @pageclick="goToPage" 
                @countchange="updateCount"
                v-show="pagination.from"
                :pagination="pagination"
                :processing="isProcessing"></pagination>
        </div>
    </main>
</div>

@endsection
