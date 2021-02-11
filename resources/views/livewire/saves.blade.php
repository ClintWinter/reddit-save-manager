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
    x-on:keydown.arrow-left.window="$refs.previousPage.click();"
    x-on:keydown.arrow-right.window="$refs.nextPage.click();"
    x-on:keydown.shift.arrow-left.window="$refs.firstPage.click();"
    x-on:keydown.shift.arrow-right.window="$refs.lastPage.click();"
>
    {{-- loading status --}}
    <div class="fixed inset-x-0 top-0 z-50 bg-blue-600 text-white px-8 py-1" wire:loading.delay wire:target="syncSaves">
        <div class="w-full flex items-center justify-center">
            <x-svg.loading-spinner /> Syncing your saves... this can take a minute if you have a lot of unsynced saves.
        </div>
    </div>

    <x-nav :user="$user" />

    <header class="flex justify-center">
        <div class="w-full flex justify-center items-center py-2 px-4">
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
                {{ $saves->links('partials.pagination', ['perPage' => $this->perPage, 'top' => true]) }}

                @if (count($saves))
                    <section class="cards flex flex-wrap">
                        @foreach($saves as $save)
                            <div class="card-container w-full md:w-1/2 mb-4">
                                <div class="card flex flex-col m-2 rounded h-full shadow-lg">
                                    @if($save->type_id === 1)
                                        <div class="h-4 rounded-t bg-blue-gradient"></div>
                                    @elseif($save->type_id === 2)
                                        <div class="h-4 rounded-t bg-yellow-gradient"></div>
                                    @else
                                        <div class="h-4 rounded-t bg-purple-gradient"></div>
                                    @endif
                                    <div class="h-full p-2 rounded-b bg-gray-700 flex flex-col">
                                        <div class="flex items-center mb-4">
                                            <x-save-icon :type="$save->type_id" class="pl-2 pr-4 text-2xl" />

                                            <div>
                                                <h2 class="text-lg font-semibold leading-tight text-shadow overflow-ellipsis" style="height:50px;">
                                                    <a href="/saves/{{ $save->id }}" class="overflow-ellipsis">
                                                        {!! \Str::limit($save->title, 60) !!}
                                                    </a>
                                                </h2>

                                                <p class="text-2xl opacity-75 text-shadow">
                                                    <small>r/{{ $save->subreddit->name }}</small>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="relative mb-4 shadow-inner flex-grow bg-gray-800 p-2 h-80 overflow-y-hidden overflow-ellipsis text-sm rounded">
                                            <div class="description h-full">
                                                @if($save->media_url)
                                                    @if(in_array(Str::afterLast($save->media_url, '.'), ['jpg', 'jpeg', 'png']))
                                                        <img class="w-full" src="{{ $save->media_url }}" />
                                                    @else
                                                        <a href="{{ $save->media_url }}" target="_blank" rel="noopener noreferer">
                                                            {{ $save->media_url }}
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    @endif
                                                @elseif($save->body)
                                                    {!! html_entity_decode($save->body) !!}
                                                @endif
                                            </div>
                                            <div class="absolute inset-x-0 bottom-0 py-2 text-center text-lg bg-gray-900">
                                                <a href="/saves/{{ $save->id }}" class="hover:underline">View full post</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </section>
                @else
                    <div class="px-4 py-20 text-2xl italic text-center">No results!</div>
                @endif

                {{ $saves->links('partials.pagination', ['perPage' => $this->perPage, 'top' => false]) }}
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
