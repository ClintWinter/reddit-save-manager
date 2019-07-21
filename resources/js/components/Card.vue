<template>
    <div class="card rounded-lg p-3 mb-8 mx-2" :class="color">
        <h2 class="text-xl font-semibold leading-tight" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">
            <a v-bind:href="save.link_permalink ? save.link_permalink : save.url" target="_blank">{{ title }}</a>
        </h2>
        <p class="text-2xl opacity-75 mb-4" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);"><small>{{ save.subreddit_name_prefixed }}</small></p>
        <div class="description text-sm mb-16" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);" v-if="body" v-html="body"></div>
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
    props: ['save'],

    data() {
        return {
        };
    },

    computed: {
        type() {
            let prefix = this.save.name.split('_')[0];

            if ( prefix == 't1' ) {
                return 'comment';
            } else if ( prefix == 't3' ) {
                if ( this.save.media ) {
                    return 'link';
                } else {
                    return 'text';
                }
            }
        },

        title() {
            let title = this.type == 'comment' ? this.save.link_title : this.save.title;

            if ( title.length > 80 ) {
                title = title.slice(0, 75) + '...';
            }

            return title;
        },

        body() {
            let body = this.type == 'link' ? '' : (this.type == 'comment' ? this.save.body_html : this.save.selftext_html );
            
            if ( body ) {
                body = this.decodeEntities()(body);
            } else {
                return body;
            }

            if (body.length > 300) {
                body = body.slice(0, 300) + '...';
            }

            return body;
        },

        color() {
            if ( this.type == 'comment' ) {
                return 'bg-blue-gradient bg-blue-shadow';
            } else if ( this.type == 'link' ) {
                    return 'bg-yellow-gradient bg-yellow-shadow';
            } else if ( this.type == 'text' ) {
                return 'bg-purple-gradient bg-purple-shadow';
            }
        }
    },

    methods: {

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

};
</script>