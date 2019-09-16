<template>
    <div class="card-container w-full flex items-stretch">
        <div class="card w-full flex flex-col justify-between" :class="color">
            <div class="flex flex-col sm:flex-row p-2">
                <div class="pl-2 pr-8 text-lg text-shadow hidden sm:block">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x text-black"></i>
                        <i class="fa-stack-1x" :class="{'fas fa-comments text-teal-300': save.type.type == 'comment', 'fas fa-quote-left text-pink-500': save.type.type == 'text', 'fas fa-link text-orange-500': save.type.type == 'link'}"></i>
                        <!-- <i class="fas fa-flag fa-stack-1x fa-inverse"></i> -->
                    </span>
                </div>
                <div class="flex-grow">
                    <h2 class="text-xl font-semibold leading-tight text-shadow">
                        <a v-bind:href="save.link" target="_blank" rel="noreferrer noopener">{{ save.title }}</a>
                    </h2>
                    <p class="text-2xl opacity-75 mb-4 text-shadow"><small>r/{{ save.subreddit.name }}</small></p>
                    <div class="description text-sm mb-6 text-shadow" v-if="body" v-html="body"></div>
                </div>
            </div>
            <div class="py-4 p-2 flex" style="background-color: hsla(0, 100%, 0%, 15%)">
                <div class="hidden sm:block" style="width: 130px;"></div>
                <div class="w-full">
                    <div class="tags flex flex-wrap mb-2">
                        <div 
                            class="tag mr-2 px-3 py-1 rounded-full text-black shadow-md mb-2 leading-normal cursor-pointer hover:bg-gray-200 hover:text-gray-600 hover:line-through"
                            :class="{'bg-teal-300': save.type.type == 'comment', 'bg-pink-500': save.type.type == 'text', 'bg-orange-500': save.type.type == 'link'}"
                            v-for="tag in tags" 
                            :key="tag.name"
                            @click="deleteTag(tag.id, tag.name)"
                        >{{ tag.name }}</div>
                    </div>
                    <div class="w-full flex justify-between">
                        <input 
                            type="text"
                            class="text-black block px-3 py-1 rounded border-2 border-gray-200 outline-none focus:border-orange-500"
                            v-model="tag"
                            ref="taginput"
                            @keyup.enter="addTag"
                            placeholder="Add a Tag">
                        <button 
                            class="px-3 py-1 rounded text-white hover:text-yellow-400 font-bold underline"
                            @click="unsave"
                        >
                            UNSAVE
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
module.exports = {
    props: ['save'],

    data() {
        return {
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
            axios.post('/saves/' + this.save.id + '/tags', {
                tag: this.tag,
                save_id: this.save.id
            })
            .then((response) => {
                this.tags.push(response.data);
                this.tag = '';
            })
            .catch(error => {
                this.$emit('throwerror', error.response.data.errors);
                this.tag = '';
            });
        },

        deleteTag(id, name) {
            // axios.get('/saves/' + this.save.id);
            // return;
            axios.delete('/saves/' + this.save.id + '/tags/' + id)
            .then((response) => {
                this.tags = this.tags.filter(v => v.id != id);
            })
            .catch(error => {
                this.$emit('throwerror', error.response.data.errors);
            });
        },

        unsave() {
            this.$emit('unsave', this.save);
        }
        // showAddTag() {
        //     this.addInputIsVisible = true;
        //     this.$nextTick(function() {
        //         this.$refs.taginput.focus();
        //     });
        // }

    },

};
</script>