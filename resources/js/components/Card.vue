<template>
    <div class="card rounded-lg p-3 mb-8 mx-1" :class="color">
        <h2 class="text-3xl font-semibold leading-none" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">
            <a v-bind:href="save.link_permalink ? save.link_permalink : save.url" target="_blank">{{ save.title ? save.title : save.link_title }}</a>
        </h2>
        <p class="text-xl opacity-75 mb-4" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);"><small>{{ save.subreddit_name_prefixed }}</small></p>
        <div class="description text-sm mb-16" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);" v-html="this.bodyText"></div>
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
            bodyText: ''
        }
    },

    methods: {
        generateBodyText() {
            if ( this.save.body_html ) {
                this.bodyText = this.decodeEntities()(this.save.body_html);
            } else {
                // this.bodyText = `<a href="${this.save.url}">${this.save.url}</a>`;
            }

            if (this.bodyText.length > 300) {
                this.bodyText = this.bodyText.slice(0, 200) + '...';
            }
        },

        decodeEntities() {
            // this prevents any overhead from creating the object each time
            var element = document.createElement('div');

            function decodeHTMLEntities (str) {
                if(str && typeof str === 'string') {
                // strip script/html tags
                str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
                str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
                element.innerHTML = str;
                str = element.textContent;
                element.textContent = '';
                }

                return str;
            }

            return decodeHTMLEntities;
        }
    },

    created() {
        this.generateBodyText();
    }
};
</script>