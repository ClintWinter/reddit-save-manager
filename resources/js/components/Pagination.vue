<template>
    <div class="flex justify-between items-center p-2">
        <div>
            <button 
                :disabled="pagination.current == 1"
                :class="{'opacity-25': prevDisabled}"
                class="px-4 outline-none hover:text-orange-500"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);" 
                @click="pageClick(pagination.first_url)"><i class="fas fa-angle-double-left"></i></button
            ><button 
                :disabled="prevDisabled"
                :class="{'opacity-25': prevDisabled}"
                class="px-4 outline-none hover:text-orange-500"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);" 
                @click="pageClick(pagination.previous_url)"><i class="fas fa-angle-left"></i></button
            ><button 
                disabled 
                class="h-10 px-4 cursor-default font-black text-xl"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);">{{ pagination.current }}</button
            ><button 
                :disabled="nextDisabled"
                :class="{'opacity-25': nextDisabled}"
                class="px-4 outline-none hover:text-orange-500"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);" 
                @click="pageClick(pagination.next_url)"><i class="fas fa-angle-right"></i></button
            ><button 
                :disabled="pagination.current == pagination.total_pages"
                :class="{'opacity-25': nextDisabled}"
                class="px-4 outline-none hover:text-orange-500"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,.2);" 
                @click="pageClick(pagination.last_url)"><i class="fas fa-angle-double-right"></i></button>
        </div>
        <p>
            <strong>{{ pagination.from }}</strong> to 
            <strong>{{ pagination.to }}</strong> of 
            <strong>{{ pagination.total }}</strong>
            - <strong>{{ pagination.per_page }}</strong> per page
        </p>
    </div>
</template>


<script>
export default {
    props: ['pagination', 'processing'],

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
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
