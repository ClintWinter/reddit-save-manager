<header class="flex justify-center bg-gray-700">
    <div class="w-full flex justify-between py-2 px-4">
        <div class="flex-grow flex align-center">
            <input
                v-model="thisQuery"
                @keyup.enter="search"
                type="text"
                name="query"
                placeholder="Search..."
                class="w-full md:w-1/2 lg:w-1/3 rounded-full px-5 py-2 shadow-lg outline-none mr-4 text-gray-700 border-2 border-transparent focus:border-orange-500" />
        </div>
        <div class="flex items-center">
            <button
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded shadow-inner hover:bg-orange-500 hover:text-white"
                @click="$emit('togglefilters')">
                <i
                    class="fas fa-filter text-3xl"
                    style="text-shadow: 0 0 4px rgba(0,0,0,.15)"></i>
            </button>
        </div>
    </div>
</header>
