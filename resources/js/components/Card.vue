<template>
    <div class="card max-w-sm m-3 rounded-lg p-3" :class="color">
        <h2 class="text-3xl font-semibold leading-none" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">
            <a v-bind:href="save.link_permalink" target="_blank">{{ save.title ? save.title : save.link_title }}</a>
        </h2>
        <p class="text-xl opacity-75 mb-4" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);"><small>{{ save.subreddit_name_prefixed }}</small></p>
        <p class="description text-md mb-16" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);" v-html="save.body_html ? save.body_html : save.url"></p>
        <!-- <div class="tags flex flex-wrap">
            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 1</div>
            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 2</div>
            <div class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md">Tag 3</div>
        </div> -->
    </div>
</template>

// TODO: Different types of posts have different data to work with: need to find a reliable way to get a video/img post, text post, or a comment and render them the right way.
<script>
module.exports = {
    props: ['save', 'color'],
    data() {
        return {
        }
    }
};
</script>

<style scoped>

</style>