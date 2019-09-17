@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col font-body">
    <nav class="bg-gray-800 flex justify-center">
        <div class="w-full flex justify-between items-center py-2 px-4">
            <div class="flex items-center">
                <div class="mr-2" style="height: 50px; width: 50px;">
                    <svg class="w-full h-full shadow-lg rounded-full" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="460" height="460" viewBox="0 0 460 460"><defs><clipPath id="a"><rect width="460" height="460" fill="none"/></clipPath><linearGradient id="b" x1="0.5" x2="0.5" y2="1.132" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#ff7d14"/><stop offset="1" stop-color="#ed041d"/></linearGradient><linearGradient id="c" y1="-7.618" y2="5.882" xlink:href="#b"/><clipPath id="d"><rect width="80" height="80" fill="none"/></clipPath><linearGradient id="e" y1="-3.353" y2="4.733" xlink:href="#b"/></defs><g clip-path="url(#a)"><circle cx="230" cy="230" r="230" fill="url(#b)"/><ellipse cx="161.5" cy="99" rx="161.5" ry="99" transform="translate(69 195.023)" fill="#fff"/><circle cx="37.5" cy="37.5" r="37.5" transform="translate(48 212.023)" fill="#fff"/><circle cx="37.5" cy="37.5" r="37.5" transform="translate(337 212.023)" fill="#fff"/><circle cx="30" cy="30" r="30" transform="translate(315 77.023)" fill="#fff"/><path d="M7393,576.181s92.437,100.634,185,0" transform="translate(-7255.005 -253.119)" fill="url(#c)"/><path d="M7436.5,453l22.28-132.023,69.72,21.048" transform="translate(-7206 -244.977)" fill="none" stroke="#fff" stroke-linejoin="round" stroke-width="20"/><g transform="translate(253 224.496)" clip-path="url(#d)"><path d="M7397.183,49.935l9.173,29.4h29.36l-23.685,18.184,9.222,29.625-24.07-18.321s-23.635,19.052-23.635,18.321,9.277-29.625,9.277-29.625L7358.8,79.337h29.286Z" transform="translate(-7357.25 -48.328)" fill="url(#e)"/></g><g transform="translate(128 224.496)" clip-path="url(#d)"><path d="M7397.183,49.935l9.173,29.4h29.36l-23.685,18.184,9.222,29.625-24.07-18.321s-23.635,19.052-23.635,18.321,9.277-29.625,9.277-29.625L7358.8,79.337h29.286Z" transform="translate(-7357.25 -48.328)" fill="url(#e)"/></g></g></svg>
                </div>
                <h2 class="text-gray-500 text-4xl font-display">RESAVMA</h2>
            </div>
            <div>
                <button 
                    class="m-0 p-0 text-white"
                    @click="showNavDropdown = !showNavDropdown"
                    ref="navDropdown">@{{ user.name }} <i class="fas fa-cog"></i></button>
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
                                    class="block text-gray-900 hover:bg-gray-300 px-8 py-2"
                                    href="javascript:;"
                                    @click="getNewSaves"
                                >Load New Saves</a>
                            </li>
                            <li>
                                <a 
                                    class="block text-gray-900 hover:bg-gray-300 px-8 py-2"
                                    href="{{ route('logout') }}" 
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                >Sign Out</a>
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
        </form>
    </navigation> --}}

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
                    @throwerror="displayErrors"
                    @unsave="unsave"></card>
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
