<nav class="flex justify-center">
    <div class="w-full flex justify-between items-center py-2 px-4">
        {{-- left --}}
        <div class="flex items-center text-xl">
            <div class="mr-2" style="height: 40px; width: 40px;">
                <x-logo />
            </div>
            <h2 class="text-gray-500 font-display leading-none pt-2 uppercase">Resavma</h2>
        </div>

        {{-- right --}}
        <div x-data="{open:false}">
            <button class="rounded border border-white m-0 px-6 py-1 text-white flex items-center focus:outline-none focus:border-yellow-500" @click="open=true">
                <span class="text-base pr-4">{{ $user->name }}</span>
                <i class="fas fa-cog text-xl"></i>
            </button>

            <div x-show="open" @click.away="open=false" class="bg-white rounded border-1 bg-gray-100 absolute top-3 right-0 mr-4 shadow-lg" x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <ul>
                    <li><a class="block rounded-t text-gray-900 hover:bg-yellow-300 px-8 py-2" href="javascript:;" onclick="event.preventDefault();document.getElementById('sync-form').submit();">Sync saves</a></li>
                    <li><a class="block rounded-b text-gray-900 hover:bg-yellow-300 px-8 py-2" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign Out</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <form id="sync-form" action="/saves" method="POST" style="display: none;">@csrf</form>
            </div>
        </div>
    </div>
</nav>
