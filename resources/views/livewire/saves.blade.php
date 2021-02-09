<div class="text-gray-100 bg-gray-800 text-white min-h-screen flex flex-col font-body"
    x-data="{filtersModal: false, navMenu: false}"
    x-on:open-filters.window="
        filtersModal = true;
        $nextTick(() => { $refs.firstFilter.focus(); });
    "

    x-on:keyup.slash.window="$refs.search.focus();"
    x-on:keydown.cmd.k.window="$dispatch('open-filters', {});"
    x-on:keydown.escape.window="filtersModal = false;"
    x-on:keydown.cmd.j.window="$refs.syncBtn.click();"
>
    {{-- loading status --}}
    <div class="fixed inset-x-0 top-0 z-50 bg-blue-600 text-white px-8 py-1" wire:loading.delay wire:target="syncSaves">
        <div class="w-full flex items-center justify-center">
            <x-svg.loading-spinner /> Syncing your saves... this can take a minute if you have a lot of unsynced saves.
        </div>
    </div>

    <x-nav :user="$user" />

    {{-- <div x-text="x"></div> --}}

    {{-- error flash --}}
    @if($errors->any())
        <div class="px-5 py-2 bg-red-800 fixed shadow-md inset-x-0 top-0 z-20">
            <p class="text-lg font-bold color-white">{{ $errors->first() }}</p>
        </div>
    @endif

    {{-- <livewire:save-filters-modal /> --}}

    <header class="flex justify-center">
        <div class="w-full flex justify-center items-center py-2 px-4 shadow-inner">
            <input x-ref="search" placeholder="Search - Press / to focus" class="w-full px-5 py-2 mr-4 rounded bg-transparent text-gray-100 focus:outline-none ring-2 ring-transparent focus:ring-yellow-500" wire:model.debounce.500ms="search">

            <button id="filters" class="px-4 py-1 rounded focus:outline-none ring-2 ring-transparent focus:ring-yellow-500" x-on:click="$dispatch('open-filters', {});" title="cmd + k">
                <i class="fas fa-filter text-3xl text-shadow-dark-bg"></i>
            </button>
        </div>
    </header>

    <div class="h-1 border-b border-gray-600 mx-2"></div>

    <main class="flex justify-center flex-grow">
        <div class="container">
            <div class="w-full flex flex-col pt-8 pb-20">
                {{ $saves->links('partials.pagination', ['perPage' => $this->perPage]) }}

                @if (count($saves))
                    <section class="cards flex flex-wrap justify-start items-stretch">
                        @foreach($saves as $save)
                            <div class="card-container w-full md:w-1/2 mb-4 items-stretch">
                                <div class="card flex flex-col pt-3 m-2 rounded h-full shadow-md @if($save->type_id === 1) bg-blue-gradient @elseif($save->type_id === 2) bg-yellow-gradient @else bg-purple-gradient @endif">
                                    <div class="h-full p-2 rounded-b bg-gray-700">
                                        <div class="flex items-center mb-4">
                                            <x-save-icon :type="$save->type_id" class="pl-2 pr-4 text-2xl" />

                                            <div>
                                                <h2 class="text-xl font-semibold leading-tight text-shadow">
                                                    <a href="{{ $save->reddit_url }}" target="_blank" rel="noreferer noopener">
                                                        {!! \Str::limit($save->title, 100) !!}
                                                    </a>
                                                </h2>

                                                <p class="text-2xl opacity-75 text-shadow">
                                                    <small>r/{{ $save->subreddit->name }}</small>
                                                </p>
                                            </div>
                                        </div>

                                        @if($save->media_url)
                                            @if(in_array(Str::afterLast($save->media_url, '.'), ['jpg', 'jpeg', 'png']))
                                                <img class="w-full" src="{{ $save->media_url }}" />
                                            @else
                                                <div class="description p-2 max-h-96 overflow-y-scroll text-sm rounded">
                                                    <a href="{{ $save->media_url }}" target="_blank" rel="noopener noreferer">
                                                        {{ $save->media_url }}
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        @elseif($save->body)
                                            <div class="description p-2 max-h-96 overflow-y-scroll text-sm rounded">
                                                {!! html_entity_decode($save->body) !!}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- TODO: tags --}}
                                    {{-- <div class="py-4 p-2 flex bg-gray-700 rounded-b">
                                        <div class="tags flex flex-wrap mb-2">
                                            @foreach($save->tags as $tag)
                                                <div class="tag mr-2 px-3 py-1 rounded-full text-black shadow-md mb-2 leading-normal cursor-pointer bg-gray-100 hover:bg-gray-300 hover:text-gray-600 hover:line-through"
                                                >{{ $tag->name }}</div>
                                            @endforeach
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        @endforeach
                    </section>
                @else
                    <div class="px-4 py-20 text-2xl italic text-center">No results!</div>
                @endif

                {{ $saves->links('partials.pagination', ['perPage' => $this->perPage]) }}
            </div>
        </div>
    </main>

    <div x-cloak x-show="filtersModal" class="fixed inset-0 flex justify-center items-end sm:items-center">
        <div class="absolute inset-0 bg-black opacity-75 z-20" x-on:click="filtersModal = false"></div>

        <div class="absolute px-6 py-12 bg-gray-700 rounded shadow-lg z-30 mb-20">
            <div class="mb-12">Press <kbd class="bg-gray-800 p-1 rounded shadow-inner">Esc</kbd> to close.</div>

            <div class="flex mb-6">
                <label class="w-32">Type</label>
                <select x-ref="firstFilter" class="flex-grow text-gray-100 bg-transparent p-2 rounded border border-gray-600 focus:outline-none ring-2 ring-transparent focus:ring-yellow-500" wire:model="filters.type">
                    <option value="">-</option>
                    <option value="1">Comment</option>
                    <option value="2">Link</option>
                    <option value="3">Text</option>
                </select>
            </div>

            <div class="flex">
                <label class="w-32">Subreddit</label>
                <select class="flex-grow text-gray-100 bg-transparent p-2 rounded border border-gray-600 focus:outline-none ring-2 ring-transparent focus:ring-yellow-500" wire:model="filters.subreddit">
                    <option value="">-</option>
                    @foreach($subreddits as $subreddit)
                        <option value="{{ $subreddit->id }}">{{ "$subreddit->name ($subreddit->count)" }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
