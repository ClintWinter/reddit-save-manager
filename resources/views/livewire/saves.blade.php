<div class="bg-main-vdark text-white min-h-screen flex flex-col font-body"
    x-data="{filtersModal: false, navMenu: false}"
    x-on:open-filters.window="
        filtersModal = true;
        $nextTick(() => { $dispatch('focus-element', 'type') });
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

    <header class="flex justify-center container mx-auto mb-8">
        <div class="w-full flex justify-center items-center py-2 px-4">
            <input x-ref="search" placeholder="Search - Press / to focus" class="w-full h-12 px-5 py-2 mr-4 rounded text-base bg-transparent border-2 border-inactive focus:border-main-blue outline-none" wire:model.debounce.500ms="search">

            <button id="filters" class="h-12 px-4 py-1 rounded focus:outline-none bg-white bg-opacity-10 border-2 border-transparent hover:border-main-blue" x-on:click="$dispatch('open-filters', {});" title="cmd + k">
                <i class="fas fa-filter text-3xl"></i>
            </button>
        </div>
    </header>

    <main class="flex justify-center flex-grow">
        <div class="container">
            <div class="w-full flex flex-col pt-8 pb-20">
                {{ $saves->links('partials.pagination', ['perPage' => $this->perPage, 'top' => true]) }}

                @if (count($saves))
                    <section class="cards flex flex-wrap">
                        @foreach($saves as $save)
                            <div class="card-container w-full md:w-1/2 mb-4">
                                <div class="card flex flex-col m-4 rounded h-full">
                                    <div class="relative h-full p-4 rounded-sm bg-main-dark flex flex-col">
                                        <div class="flex items-center mb-4">
                                            <i class="inline-block pr-4 text-4xl @if($save->type === 1) fas fa-comments  @elseif($save->type === 3) fas fa-quote-left @else fas fa-link @endif text-main-blue opacity-50"></i>

                                            <div>
                                                <p class="text-base text-main-teal font-bold">
                                                    r/{{ $save->subreddit->name }}
                                                </p>

                                                <h2 class="text-2xl leading-tight font-semibold">
                                                    <a href="/saves/{{ $save->id }}">
                                                        {!! \Str::limit($save->title, 60) !!}
                                                    </a>
                                                </h2>
                                            </div>
                                        </div>

                                        <div class="relative flex-grow mb-4 p-2 h-80 overflow-y-hidden overflow-ellipsis text-sm">
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
                                                    <div class="text-white opacity-75">{!! html_entity_decode($save->body) !!}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="/saves/{{ $save->id }}" class="block absolute inset-x-0 bottom-0 py-3 text-center uppercase text-base bg-main-blue bg-opacity-50 rounded-b-sm" style="backdrop-filter: blur(3px);">
                                            View more
                                        </a>
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

        <div class="absolute px-6 py-12 bg-main-vdark rounded shadow-lg z-30 mb-20">
            <div class="mb-12">Press <kbd class="bg-main-vdark p-1 rounded shadow-inner">Esc</kbd> to close.</div>

            <x-form-field.select label="type" wire:model="filters.type">
                <option value="">-</option>
                <option value="1">Comment</option>
                <option value="2">Link</option>
                <option value="3">Text</option>
            </x-form-field.select>

            <x-form-field.select label="subreddit" wire:model="filters.subreddit">
                <option value="">-</option>
                @foreach($subreddits as $subreddit)
                    <option value="{{ $subreddit->id }}">{{ "$subreddit->name ($subreddit->count)" }}</option>
                @endforeach
            </x-form-field.select>
        </div>
    </div>
</div>
