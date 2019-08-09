@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col">
    <navigation :user="user">
        <a 
            href="{{ route('logout') }}" 
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">@{{ user.name }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
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
