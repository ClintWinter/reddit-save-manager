<nav class="container mx-auto flex justify-center py-4">
    <div class="w-full flex justify-between items-center py-2 px-4">
        {{-- left --}}
        <div class="flex items-center pt-2">
            {{-- <div class="mr-2" style="height: 40px; width: 40px;"><x-logo /></div> --}}
            <h2 class="text-xl font-black leading-none uppercase">Resavma</h2>
            <div class="pl-8 flex items-center leading-none">
                <a href="/saves" class="p-1 mx-2 uppercase text-sm">Saves</a>
            </div>
        </div>

        {{-- right --}}
        <div class="relative">
            <button class="relative flex items-center px-4 py-1 bg-white bg-opacity-10 rounded-sm focus:outline-none" @click="navMenu=true">
                <span class="pr-4">Account</span>
                <i class="fas fa-caret-down text-xl"></i>
            </button>

            <div x-show="navMenu" @click.away="navMenu=false" class="absolute w-72 top-3 right-0 bg-main-dark rounded-sm shadow-lg z-10" x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
            >
                <ul>
                    <li>
                        <a x-ref="syncBtn" class="block rounded-t hover:bg-main-blue font-bold px-8 py-2" href="javascript:;" wire:click="syncSaves" @click="open=false">
                            Sync saves <kbd class="bg-main-vdark p-1 rounded-sm">cmd + j</kbd>
                        </a>
                    </li>
                    <li>
                        <a class="block hover:bg-main-blue font-bold px-8 py-2" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Sign Out
                        </a>
                    </li>
                    <li class="px-8 py-2 pt-4 text-gray-400 text-sm">
                        Signed in as {{ $user->name }}
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                <form id="sync-form" action="/saves" method="POST" style="display: none;">@csrf</form>
            </div>
        </div>
    </div>
</nav>
