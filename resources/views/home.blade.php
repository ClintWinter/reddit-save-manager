@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col font-body">

    <x-nav />

    {{-- error flash --}}
    @if($errors->any())
        <div
            v-if="errors.length > 0"
            class="px-5 py-2 bg-red-800 fixed shadow-md inset-x-0 top-0 z-20">
            <p
                class="text-lg font-bold color-white"
                v-for="(error, index) in errors"
                :key="index">{{ $errors->first() }}</p>
        </div>
    @endif

    {{-- filters modal --}}
    {{-- <section
        id="modal"
        class="fixed inset-0 flex justify-center items-center z-50"
        v-show="showFilters">
            <div @click="$emit('togglefilters')" class="absolute inset-0 bg-black opacity-50"></div>
            <div class="z-20 bg-white shadow-2xl rounded text-black p-2 mx-2 md:mx-5">
                <div class="flex justify-between items-center mb-10 leading-none">
                    <h4 class="text-gray-700 font-bold text-xl">Filters</h4>
                    <button @click="$emit('togglefilters')" class="text-gray-500 hover:text-gray-700 text-4xl">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>

                <div class="p-5">
                    <div class="flex justify-between items-center">
                        <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Subreddit</label>
                        <select
                            class="w-64 block h-8 my-4 bg-gray-200 rounded"
                            v-model="subreddit"
                            @change="filterSubreddit">
                            <option value="">--</option>
                            <option key="subreddit" v-for="subreddit in subreddits">{{ subreddit }}</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center">
                        <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Tag</label>
                        <select
                            class="w-64 block h-8 my-4 bg-gray-200 rounded"
                            v-model="tag"
                            @change="filterTag">
                            <option value="">--</option>
                            <option :key="tag" v-for="tag in tags">{{ tag }}</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center">
                        <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Type</label>
                        <select
                            class="w-64 block h-8 my-4 bg-gray-200 rounded"
                            v-model="type"
                            @change="filterType">
                            <option value="">--</option>
                            <option :key="type" v-for="type in types">{{ type }}</option>
                        </select>
                    </div>
                    <div class="block flex justify-end">
                        <button class="p-0 m-0 underline text-blue-500" @click="clearFilters">Clear Filters</button>
                    </div>
                </div>
            </div>
    </section> --}}

    {{-- search --}}
    {{-- <header class="flex justify-center bg-gray-700">
        <div class="w-full flex justify-between py-2 px-4">
            <div class="flex-grow flex align-center">
                <input
                    v-model="thisQuery"
                    @keyup.enter="search"
                    type="text"
                    name="query"
                    placeholder="Search..."
                    class="w-full md:w-1/2 lg:w-1/3 rounded-full px-5 py-2 shadow-lg outline-none mr-4 text-gray-700 border-2 border-transparent focus:border-orange-500" />
            </div>
            <div class="flex items-center">
                <button
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded shadow-inner hover:bg-orange-500 hover:text-white"
                    @click="$emit('togglefilters')">
                    <i
                        class="fas fa-filter text-3xl"
                        style="text-shadow: 0 0 4px rgba(0,0,0,.15)"></i>
                </button>
            </div>
        </div>
    </header> --}}

    <main class="flex justify-center bg-gray-900 flex-grow">
        <div class="container">
            <div class="w-full flex flex-col pt-8 pb-20">

                {{-- pagination --}}
                {{-- <div class="flex justify-between items-center p-2">
                    <div class="flex justify-around fixed inset-x-0 bottom-0 bg-gray-900 md:inline-block md:static md:inset-x-auto md:bottom-auto z-10">
                        <button
                            :disabled="pagination.current == 1"
                            :class="{'opacity-25': prevDisabled}"
                            class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);"
                            @click="pageClick(pagination.first_url)"><i class="fas fa-angle-double-left"></i></button
                        ><button
                            :disabled="prevDisabled"
                            :class="{'opacity-25': prevDisabled}"
                            class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);"
                            @click="pageClick(pagination.previous_url)"><i class="fas fa-angle-left"></i></button
                        ><button
                            disabled
                            class="text-3xl md:text-xl h-10 px-4 cursor-default font-black"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);">{{ pagination.current }}</button
                        ><button
                            :disabled="nextDisabled"
                            :class="{'opacity-25': nextDisabled}"
                            class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);"
                            @click="pageClick(pagination.next_url)"><i class="fas fa-angle-right"></i></button
                        ><button
                            :disabled="pagination.current == pagination.total_pages"
                            :class="{'opacity-25': nextDisabled}"
                            class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);"
                            @click="pageClick(pagination.last_url)"><i class="fas fa-angle-double-right"></i></button>
                    </div>
                    <div class="w-full flex justify-between md:w-auto md:inline-block">
                        <div class="block md:inline md:border-r-2 md:border-white md:pr-3 md:mr-2">
                            <strong>{{ pagination.from }}</strong> to
                            <strong>{{ pagination.to }}</strong> of
                            <strong>{{ pagination.total }}</strong>
                        </div>
                        <!-- <span class="hidden md:inline"> | </span> -->
                        <div class="block md:inline">
                            <select class="inline-block text-orange-600" v-model="count" @change="countChanged()">
                                <option selected="selected">15</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            per page
                        </div>
                    </div>
                </div> --}}

                {{-- cards --}}
                <section class="cards flex flex-wrap justify-start items-stretch">
                    @foreach($saves as $save)
                        <div class="card-container w-full flex items-stretch">
                            <div class="card w-full flex flex-col justify-between @if($save->type_id === 1)bg-blue-gradient bg-blue-shadow @elseif($save->type_id === 2) bg-yellow-gradient bg-yellow-shadow @else bg-purple-gradient bg-purple-shadow @endif">
                                <div class="flex flex-col sm:flex-row p-2">
                                    <div class="pl-2 pr-8 text-lg text-shadow hidden sm:block">
                                        <span class="fa-stack fa-2x">
                                            <i class="fas fa-circle fa-stack-2x text-black"></i>
                                            <i class="fa-stack-1x @if($save->type_id === 1) fas fa-comments text-teal-300 @elseif($save->type_id === 3) fas fa-quote-left text-pink-500 @else fas fa-link text-orange-500 @endif"></i>
                                        </span>
                                    </div>

                                    <div class="flex-grow">
                                        <h2 class="text-xl font-semibold leading-tight text-shadow">
                                            {{ $save->title }}
                                            {{-- <a v-bind:href="save.link" target="_blank" rel="noreferrer noopener">{{ save.title }}</a> --}}
                                        </h2>

                                        <p class="text-2xl opacity-75 mb-4 text-shadow">
                                            <small>r/{{ $save->subreddit->name }}</small>
                                        </p>

                                        @if($save->body)
                                            <div class="description text-sm mb-6 text-shadow">{!! html_entity_decode($save->body) !!}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="py-4 p-2 flex" style="background-color: hsla(0, 100%, 0%, 15%)">
                                    <div class="hidden sm:block" style="width: 130px;"></div>
                                    <div class="w-full">
                                        <div class="tags flex flex-wrap mb-2">
                                            @foreach($save->tags as $tag)
                                                <div class="tag mr-2 px-3 py-1 rounded-full text-black shadow-md mb-2 leading-normal cursor-pointer hover:bg-gray-200 hover:text-gray-600 hover:line-through @if($save->type_id === 1) bg-teal-300 @elseif($save->type_id === 3) bg-pink-500 @else bg-orange-500 @endif"
                                                    {{-- v-for="tag in tags"
                                                    :key="tag.name"
                                                    @click="deleteTag(tag.id, tag.name)" --}}
                                                >{{ $tag->name }}</div>
                                            @endforeach
                                        </div>
                                        <div class="w-full flex justify-between">
                                            <input type="text" class="text-black block px-3 py-1 rounded border-2 border-gray-200 outline-none focus:border-orange-500">
                                            {{-- v-model="tag" ref="taginput" @keyup.enter="addTag" placeholder="Add a Tag" --}}
                                            <button class="px-3 py-1 rounded text-white hover:text-yellow-400 font-bold underline" @click="unsave">Unsave</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </section>

                {{-- pagination --}}
                {{-- <div class="flex justify-between items-center p-2">
                    <div class="flex justify-around fixed inset-x-0 bottom-0 bg-gray-900 md:inline-block md:static md:inset-x-auto md:bottom-auto z-10">
                        <button
                            :disabled="pagination.current == 1"
                            :class="{'opacity-25': prevDisabled}"
                            class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);"
                            @click="pageClick(pagination.first_url)"><i class="fas fa-angle-double-left"></i></button
                        ><button
                            :disabled="prevDisabled"
                            :class="{'opacity-25': prevDisabled}"
                            class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);"
                            @click="pageClick(pagination.previous_url)"><i class="fas fa-angle-left"></i></button
                        ><button
                            disabled
                            class="text-3xl md:text-xl h-10 px-4 cursor-default font-black"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);">{{ pagination.current }}</button
                        ><button
                            :disabled="nextDisabled"
                            :class="{'opacity-25': nextDisabled}"
                            class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);"
                            @click="pageClick(pagination.next_url)"><i class="fas fa-angle-right"></i></button
                        ><button
                            :disabled="pagination.current == pagination.total_pages"
                            :class="{'opacity-25': nextDisabled}"
                            class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);"
                            @click="pageClick(pagination.last_url)"><i class="fas fa-angle-double-right"></i></button>
                    </div>
                    <div class="w-full flex justify-between md:w-auto md:inline-block">
                        <div class="block md:inline md:border-r-2 md:border-white md:pr-3 md:mr-2">
                            <strong>{{ pagination.from }}</strong> to
                            <strong>{{ pagination.to }}</strong> of
                            <strong>{{ pagination.total }}</strong>
                        </div>
                        <!-- <span class="hidden md:inline"> | </span> -->
                        <div class="block md:inline">
                            <select class="inline-block text-orange-600" v-model="count" @change="countChanged()">
                                <option selected="selected">15</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            per page
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </main>
</div>

@endsection
