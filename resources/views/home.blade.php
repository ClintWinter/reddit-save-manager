@extends('layouts.app')

@section('content')

<div id="app" class="text-gray-100 bg-gray-900 text-white min-h-screen flex flex-col font-body">
    <x-nav :user="$user" />

    {{-- error flash --}}
    @if($errors->any())
        <div v-if="errors.length > 0" class="px-5 py-2 bg-red-800 fixed shadow-md inset-x-0 top-0 z-20">
            <p class="text-lg font-bold color-white" v-for="(error, index) in errors" :key="index">
                {{ $errors->first() }}
            </p>
        </div>
    @endif

    {{-- <livewire:save-filters-modal /> --}}

    <header class="flex justify-center">
        <div class="w-full flex justify-center items-center py-2 px-4">
            <input id="search" placeholder="Search - Press / to focus" class="bg-transparent w-full md:w-1/2 lg:w-1/3 px-5 py-2 mr-4 rounded text-gray-100 focus:outline-none ring-2 ring-transparent focus:ring-yellow-500">

            <button class="px-4 py-1 rounded focus:outline-none ring-2 ring-transparent focus:ring-yellow-500" @click="$emit('togglefilters')">
                <i class="fas fa-filter text-3xl" style="text-shadow: 0 0 4px rgba(0,0,0,.15)"></i>
            </button>
        </div>
    </header>

    <main class="flex justify-center bg-gray-900 flex-grow">
        <div class="container">
            <div class="w-full flex flex-col pt-8 pb-20">
                {{ $saves->links('partials.pagination', ['perPage' => $perPage]) }}

                <section class="cards flex flex-wrap justify-start items-stretch">
                    @foreach($saves as $save)
                        <div class="card-container w-1/2 mb-4 items-stretch">
                            <div class="card flex flex-col p-2 m-2 rounded h-full shadow @if($save->type_id === 1) bg-blue-gradient @elseif($save->type_id === 2) bg-yellow-gradient @else bg-purple-gradient @endif">
                                <div class="h-full p-2 rounded-t bg-gray-900">
                                    {{-- <div class="pl-2 pr-4 text-sm text-shadow hidden sm:block">
                                        <span class="fa-stack fa-2x">
                                            <i class="fas fa-circle fa-stack-2x text-black"></i>
                                            <i class="fa-stack-1x @if($save->type_id === 1) fas fa-comments text-teal-300 @elseif($save->type_id === 3) fas fa-quote-left text-pink-500 @else fas fa-link text-orange-500 @endif"></i>
                                        </span>
                                    </div> --}}

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
                                <div class="py-4 p-2 flex bg-gray-800 rounded-b">
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

                {{ $saves->links('partials.pagination', ['perPage' => $perPage]) }}
            </div>
        </div>
    </main>
</div>

@endsection
