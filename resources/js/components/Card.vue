<template>
    <div class="card max-w-xs m-3 bg-yellow-gradient bg-yellow-shadow rounded-lg p-3">
        <h2 class="text-4xl font-semibold" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">Card Title</h2>
        <p class="text-xl opacity-75 mb-4" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);"><small>r/subreddit</small></p>
        <p class="description text-md mb-16" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">This is where the notes will display</p>
        <div class="tags flex flex-wrap">
            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 1</div>
            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 2</div>
            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 3</div>
        </div>
    </div>
</template>

<script>
module.exports = {
    props: ['title', 'subreddit', 'description', 'tags']
    data() {
        return {

        }
    }
})
</script>

<style scoped>

</style>