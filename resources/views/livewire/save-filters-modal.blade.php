<section
    id="modal"
    class="fixed inset-0 flex justify-center items-center z-50"
    v-show="showFilters">
        <div @click="$emit('togglefilters')" class="absolute inset-0 bg-black opacity-50"></div>
        <div class="z-20 bg-white shadow-2xl rounded text-black p-2 mx-2 md:mx-5">
            <div class="flex justify-between items-center mb-10 leading-none">
                <h4 class="text-gray-700 font-bold text-xl">Filters</h4>
                <button @click="$emit('togglefilters')" class="text-gray-500 hover:text-gray-700 text-4xl">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>

            <div class="p-5">
                <div class="flex justify-between items-center">
                    <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Subreddit</label>
                    <select
                        class="w-64 block h-8 my-4 bg-gray-200 rounded"
                        v-model="subreddit"
                        @change="filterSubreddit">
                        <option value="">--</option>
                        <option key="subreddit" v-for="subreddit in subreddits">{{ subreddit }}</option>
                    </select>
                </div>
                <div class="flex justify-between items-center">
                    <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Tag</label>
                    <select
                        class="w-64 block h-8 my-4 bg-gray-200 rounded"
                        v-model="tag"
                        @change="filterTag">
                        <option value="">--</option>
                        <option :key="tag" v-for="tag in tags">{{ tag }}</option>
                    </select>
                </div>
                <div class="flex justify-between items-center">
                    <label class="mr-5 text-gray-600 uppercase text-sm text-right flex-grow" for="subreddit">Type</label>
                    <select
                        class="w-64 block h-8 my-4 bg-gray-200 rounded"
                        v-model="type"
                        @change="filterType">
                        <option value="">--</option>
                        <option :key="type" v-for="type in types">{{ type }}</option>
                    </select>
                </div>
                <div class="block flex justify-end">
                    <button class="p-0 m-0 underline text-blue-500" @click="clearFilters">Clear Filters</button>
                </div>
            </div>
        </div>
</section>
