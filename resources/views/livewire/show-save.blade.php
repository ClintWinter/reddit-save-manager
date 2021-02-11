<div class="text-gray-100 bg-gray-800 text-white min-h-screen flex flex-col font-body"
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
        <div class="bg-gray-700 rounded shadow-md">
            @if($save->type_id === 1)
                <div class="h-4 rounded-t bg-blue-gradient"></div>
            @elseif($save->type_id === 2)
                <div class="h-4 rounded-t bg-yellow-gradient"></div>
            @else
                <div class="h-4 rounded-t bg-purple-gradient"></div>
            @endif
            <div class="px-4 pb-4 pt-12">
                <div class="mb-8 flex items-center">
                    <x-save-icon :type="$save->type_id" class="pl-2 pr-4 text-2xl" />
                    <div>
                        <h1 class="mb-2 text-3xl leading-tight">
                            {{ $save->title }}
                        </h1>
                        <div class="text-lg text-gray-300">r/{{ $save->subreddit->name }}</div>
                    </div>
                </div>
                <div class="mb-2 description shadow-inner flex-grow bg-gray-800 p-2 rounded">
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
                <div class="text-right mb-8">
                    <a href="{{ $save->reddit_url }}" class="text-gray-300 text-sm hover:underline" target="_blank" rel="noopener noreferer">View in reddit</a>
                </div>
                <button x-on:click="metadata = !metadata" class="mb-4 px-6 py-2 rounded-sm text-sm bg-gray-900 text-gray-200 focus:outline-none">Toggle details</button>
                <div x-cloak x-show="metadata" class="text-gray-300 leading-tight text-sm">
                    @php $metadata = json_decode($save->metadata, true); @endphp
                    @foreach($metadata as $key => $value)
                        <span><span class="text-gray-400">{{ $key }}:</span> {!! json_encode($value) !!},</span>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

</div>
