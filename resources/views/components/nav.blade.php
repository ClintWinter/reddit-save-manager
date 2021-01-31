<nav class="bg-gray-800 flex justify-center">
    <div class="w-full flex justify-between items-center py-2 px-4">
        {{-- left --}}
        <div class="flex items-center">
            <div class="mr-2" style="height: 50px; width: 50px;">
                <x-logo />
            </div>
            <h2 class="text-gray-500 text-4xl font-display">RESAVMA</h2>
        </div>

        {{-- right --}}
        <div x-data="{open:false}" x-cloak>
            <button class="m-0 p-0 text-white text-2xl" @click="open=true">
                <span class="text-lg">{{ $user->name }}</span>
                <i class="fas fa-cog"></i>
            </button>

            <div x-show="open" @click.away="open=false" class="bg-white rounded border-1 bg-gray-100 absolute top-3 right-0 mr-4 shadow-lg"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <ul>
                    <li><a class="block rounded-t text-gray-900 hover:bg-gray-300 px-8 py-2" onclick="event.preventDefault();document.getElementById('sync-form').submit();">Sync saves</a></li>
                    <li><a class="block rounded-b text-gray-900 hover:bg-gray-300 px-8 py-2" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign Out</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <form id="sync-form" action="/saves" method="POST" style="display: none;">@csrf</form>
            </div>
        </div>
    </div>
</nav>
