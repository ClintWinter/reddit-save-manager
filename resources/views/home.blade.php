@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col">
    <navigation :user="user"></navigation>

    <modal 
        :show-filters="showFilters"
        :subreddits="subreddits"
        :tags="tags"
        :types="types"
        @togglefilters="toggleFilters"></modal>

    <search @filterresults="filterResults" @togglefilters="toggleFilters"></search>

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
