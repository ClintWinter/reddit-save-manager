@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col font-body">
    <nav class="bg-gray-800 flex justify-center">
        <div class="w-full flex justify-between items-center py-2 px-4">
            <div class="flex items-center">
                <div class="mr-2" style="height: 50px; width: 50px;">
                    @svg('Resavma-logo', 'w-full h-full shadow-lg rounded-full')
                </div>
                <h2 class="font-bold text-2xl">Resavma</h2>
                {{-- <h3 class="logo font-black text-xl flex items-center p-1">
                    <span class="fa-stack font-normal fa-3x mr-3" style="height: 60px; width: 60px;">
                        <i class="fas fa-circle fa-stack-1x leading-none" style="font-size: 95%"></i>
                        <i class="fab fa-reddit fa-stack-1x leading-none" style="color: #FF4500;"></i>
                    </span> Resavma
                </h3> --}}
            </div>
            <div>
                <button 
                    class="m-0 p-0 text-white"
                    @click="showNavDropdown = !showNavDropdown"
                    ref="navDropdown">@{{ user.name }}</button>
                <transition name="fade">
                    <div 
                        class="bg-white rounded border-1 bg-gray-100 py-5 absolute top-3 right-0 mr-4 shadow-lg"
                        v-show="showNavDropdown"
                        v-closable="{
                            exclude: ['navDropdown'],
                            handler: 'hideNav'
                        }">
                        <ul>
                            <li>
                                <a 
                                    class="text-gray-900 hover:bg-gray-300 px-8 py-2"
                                    href="{{ route('logout') }}" 
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign Out</a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </transition>
            </div>
        </div>
    </nav>
    {{-- <navigation :user="user">
        <a 
            href="{{ route('logout') }}" 
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">@{{ user.name }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form> --}}
    </navigation>

    <error-flash
        :errors="errors"></error-flash>

    <modal 
        :show-filters="showFilters"
        :subreddits="subreddits"
        :tags="tags"
        :types="types"
        @togglefilters="toggleFilters"
        @updatesubreddit="updateSubreddit"
        @updatetag="updateTag"
        @updatetype="updateType"
        @clearfilters="clearFilters"></modal>

    <search @filterresults="filterResults" @togglefilters="toggleFilters"></search>

    <main class="flex justify-center bg-gray-900 flex-grow">
        <div class="container">
            <div class="w-full flex flex-col pt-8 pb-20">
                <pagination 
                    @pageclick="goToPage"
                    @countchange="updateCount"
                    v-show="pagination.from"
                    :pagination="pagination"
                    :processing="isProcessing"></pagination>
                <section class="cards flex flex-wrap justify-start items-stretch">
                    <card 
                    v-for="save in saves" 
                    :save="save" 
                    :key="save.reddit_id"
                    @throwerror="displayErrors"></card>
                </section>
                <pagination 
                    class="hidden md:flex"
                    @pageclick="goToPage" 
                    @countchange="updateCount"
                    v-show="pagination.from"
                    :pagination="pagination"
                    :processing="isProcessing"></pagination>
            </div>
        </div>
    </main>
</div>

@endsection
