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
                <button><i class="fas fa-filter text-3xl" style="text-shadow: 1px 2px 4px rgba(0,0,0,.2);"></i></button>
            </div>
        </div>
    </header>


    <main class="flex justify-center bg-gray-900 flex-grow">
        <div class="w-full flex flex-col px-4 pt-8 pb-40">
            <pagination 
                @pageclick="goToPage" 
                v-show="pagination.from"
                :pagination="pagination"
                :processing="isProcessing"></pagination>
            <section class="cards flex flex-wrap justify-start items-stretch">
                <card v-for="(save, index) in saves" :save="save"></card>
            </section>
            <pagination 
                @pageclick="goToPage" 
                v-show="pagination.from"
                :pagination="pagination"
                :processing="isProcessing"></pagination>
        </div>
    </main>
</div>

@endsection
