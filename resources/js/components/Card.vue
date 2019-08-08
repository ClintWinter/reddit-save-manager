<template>
    <div class="card-container w-full md:w-1/2 py-3 px-2 flex items-stretch">
        <div class="card rounded-lg w-full p-2 flex flex-col justify-between" :class="color">
            <div>
                <h2 class="text-xl font-semibold leading-tight" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);">
                    <a v-bind:href="save.link" target="_blank">{{ save.title }}</a>
                </h2>
                <p class="text-2xl opacity-75 mb-4" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);"><small>r/{{ save.subreddit.name }}</small></p>
                <div class="description text-sm mb-16" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.15);" v-if="body" v-html="body"></div>
            </div>
            <div>
                <div class="tags flex flex-wrap">
                    <div 
                        class="tag mx-1 px-3 py-1 rounded-full bg-white opacity-75 text-black shadow-md mb-2 leading-normal"
                        v-for="tag in tags" 
                        :key="tag.name">{{ tag.name }}</div>
                    <input 
                        type="text"
                        class="block rounded px-3 py-1 bg-white text-black opacity-75"
                        v-show="addInputIsVisible"
                        v-model="tag"
                        ref="taginput"
                        @keyup.enter="addTag">
                    <button
                        class="mx-1 px-3 py-2 rounded-full bg-white text-black shadow-md opacity-75 flex justify-center"
                        style="height: 32px;"
                        v-if="(save.tags.length < 10 && !addInputIsVisible)"
                        @mouseup="showAddTag"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>

// TODO: Different types of posts have different data to work with: need to find a reliable way to get a video/img post, text post, or a comment and render them the right way.
<script>
module.exports = {
    props: ['save'],

    data() {
        return {
            addInputIsVisible: false,
            tag: '',
            tags: this.save.tags
        };
    },

    computed: {
        body() {
            let body = this.decodeEntities()(this.save.body);

            if (body && body.length > 300) {
                body = body.slice(0, 300) + '...';
            }

            return body;
        },

        color() {
            if ( this.save.type.type == 'comment' ) {
                return 'bg-blue-gradient bg-blue-shadow';
            } else if ( this.save.type.type == 'link' ) {
                    return 'bg-yellow-gradient bg-yellow-shadow';
            } else if ( this.save.type.type == 'text' ) {
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
        },

        addTag() {
            axios.post('/tags', {
                tag: this.tag,
                save_id: this.save.id
            })
            .then((response) => {
                this.tags.push(response.data);
                this.tag = '';
                this.addInputIsVisible = false;
            })
            .catch(error => {
                this.$emit('throwerror', error.response.data.errors);
                this.tag = '';
                this.addInputIsVisible = false;
            });
        },

        showAddTag() {
            this.addInputIsVisible = true;
            this.$nextTick(function() {
                this.$refs.taginput.focus();
            });
        }

    },

};
</script>