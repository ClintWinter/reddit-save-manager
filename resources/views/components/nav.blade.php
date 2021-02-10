<nav class="flex justify-center py-4">
    <div class="w-full flex justify-between items-center py-2 px-4">
        {{-- left --}}
        <div class="flex items-center text-xl">
            {{-- <div class="mr-2" style="height: 40px; width: 40px;"><x-logo /></div> --}}
            <h2 class="text-gray-100 leading-none pt-2 uppercase">Resavma</h2>
        </div>

        {{-- right --}}
        <div>
            <button class="rounded m-0 text-white flex items-center text-shadow-dark-bg focus:outline-none" @click="navMenu=true">
                <i class="fas fa-cog text-xl pr-2"></i>
                <i class="fas fa-caret-down text-xl"></i>
            </button>

            <div x-show="navMenu" @click.away="navMenu=false" class="bg-white rounded border-1 bg-gray-100 absolute top-3 right-0 mr-4 shadow-lg" x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <ul>
                    <li>
                        <a x-ref="syncBtn" class="block rounded-t text-gray-900 hover:bg-yellow-400 px-8 py-2" href="javascript:;" wire:click="syncSaves" @click="open=false">
                            Sync saves <kbd class="bg-gray-200 p-1 rounded-sm">cmd + j</kbd>
                        </a>
                    </li>
                    <li>
                        <a class="block rounded-b text-gray-900 hover:bg-yellow-400 px-8 py-2" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Sign Out
                        </a>
                    </li>
                    <li class="px-8 py-2 pt-4 text-gray-500 text-sm">
                        Signed in as {{ $user->name }}
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <form id="sync-form" action="/saves" method="POST" style="display: none;">@csrf</form>
            </div>
        </div>
    </div>
</nav>
