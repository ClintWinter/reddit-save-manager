<template>
    <div class="flex justify-between items-center p-2">
        <div class="flex justify-around fixed inset-x-0 bottom-0 bg-gray-900 md:inline-block md:static md:inset-x-auto md:bottom-auto z-10">
            <button 
                :disabled="pagination.current == 1"
                :class="{'opacity-25': prevDisabled}"
                class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);" 
                @click="pageClick(pagination.first_url)"><i class="fas fa-angle-double-left"></i></button
            ><button 
                :disabled="prevDisabled"
                :class="{'opacity-25': prevDisabled}"
                class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);" 
                @click="pageClick(pagination.previous_url)"><i class="fas fa-angle-left"></i></button
            ><button 
                disabled 
                class="text-3xl md:text-xl h-10 px-4 cursor-default font-black"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);">{{ pagination.current }}</button
            ><button 
                :disabled="nextDisabled"
                :class="{'opacity-25': nextDisabled}"
                class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);" 
                @click="pageClick(pagination.next_url)"><i class="fas fa-angle-right"></i></button
            ><button 
                :disabled="pagination.current == pagination.total_pages"
                :class="{'opacity-25': nextDisabled}"
                class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);" 
                @click="pageClick(pagination.last_url)"><i class="fas fa-angle-double-right"></i></button>
        </div>
        <div class="w-full flex justify-between md:w-auto md:inline-block">
            <div class="block md:inline md:border-r-2 md:border-white md:pr-3 md:mr-2">
                <strong>{{ pagination.from }}</strong> to 
                <strong>{{ pagination.to }}</strong> of 
                <strong>{{ pagination.total }}</strong>
            </div>
            <!-- <span class="hidden md:inline"> | </span> -->
            <div class="block md:inline">
                <select class="inline-block text-orange-600" v-model="count" @change="countChanged()">
                    <option selected="selected">15</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                per page
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: ['pagination', 'processing'],

    data() {
        return {
            count: 15
        };
    },

    computed: {
        prevDisabled() {
            return this.processing || this.pagination.previous_url == null;
        },

        nextDisabled() {
            return this.processing || this.pagination.next_url == null;
        },
    },

    methods: {
        pageClick(url) {
            this.$emit('pageclick', url);
        },

        countChanged() {
            this.$emit('countchange', this.count);
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
