<div class="bg-main-vdark text-white min-h-screen flex flex-col font-body"
    x-data="{navMenu: false, metadata: false}"

    x-on:keydown.cmd.j.window="$refs.syncBtn.click();"
>
    {{-- loading status --}}
    <div class="fixed inset-x-0 top-0 z-50 bg-blue-600 text-white px-8 py-1" wire:loading.delay wire:target="syncSaves">
        <div class="w-full flex items-center justify-center">
            <x-svg.loading-spinner /> Syncing your saves... this can take a minute if you have a lot of unsynced saves.
        </div>
    </div>

    <x-nav :user="$user" />

    <div class="h-12"></div>

    <main class="container mx-auto px-2 mb-20">
        <div class="px-4 pb-4 pt-12">
            <header class="mb-8 flex items-center">
                <i class="inline-block pr-4 text-4xl @if($save->type === 1) fas fa-comments  @elseif($save->type === 3) fas fa-quote-left @else fas fa-link @endif text-main-blue opacity-50"></i>

                <div>
                    <div class="text-base text-main-teal font-bold">
                        r/{{ $save->subreddit->name }}
                    </div>
                    <h1 class="mb-2 text-4xl leading-tight font-semibold">
                        {{ $save->title }}
                    </h1>
                </div>
            </header>

            <article class="mb-2 description flex-grow">
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
                    <div class="max-w-2xl mx-auto leading-loose text-lg text-white opacity-75">{!! html_entity_decode($save->body) !!}</div>
                @endif
            </article>

            <div class="text-right mb-8">
                <a href="{{ $save->reddit_url }}" class="text-main-blue text-4xl" target="_blank" rel="noopener noreferer">
                    <i class="fab fa-reddit"></i>
                </a>
            </div>

            <div class="h-1 border-b border-white opacity-50 mb-8"></div>

            <button x-on:click="metadata = !metadata" class="mb-4 px-6 py-2 rounded-sm text-sm bg-main-dark focus:outline-none">Toggle details</button>
            <div x-cloak x-show="metadata" class="text-gray-300 leading-tight text-sm">
                @php $metadata = json_decode($save->metadata, true); @endphp
                @foreach($metadata as $key => $value)
                    <span><span class="text-gray-400">{{ $key }}:</span> {!! json_encode($value) !!},</span>
                @endforeach
            </div>
        </div>
    </main>

</div>
