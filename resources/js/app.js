import '@fortawesome/fontawesome-free';
import axios from 'axios';
window.axios = axios;

import Save from './models/Save';

// Components
import Vue from 'vue';
import Navigation from './components/Nav';
import ErrorFlash from './components/ErrorFlash';
import Search from './components/Search';
import Card from './components/Card';
import Pagination from './components/Pagination';
import Modal from './components/Modal';

// Directives
import Closable from './directives/Closable';

const app = new Vue({
    el: '#app',

    data: {
        // save: new Save(),
        saves: [],
        user: '',
        isProcessing: false,
        showFilters: false,
        showNavDropdown: false,
        subreddits: [],
        tags: [],
        types: [],
        filters: {
            count: 15,
            subreddit: '',
            tag: '',
            type: ''
        },
        pagination: {
            current: null,
            total_pages: null,
            first_url: null,
            previous_url: null,
            next_url: null,
            last_url: null,
            from: null,
            to: null,
            total: null,
        },
        errors: [],
        timeout: null,
    },

    created() {
        // this.save.all()
        // .then(function(data) {
        //     this.saves = data;
        // }.bind(this));


        
        axios.get('/saves', {
            params: {
                count: this.filters.count
            }
        })
        .then((response) => {
            this.saves = response.data.data;

            this.pagination.current = response.data.current_page;
            this.pagination.total_pages = response.data.last_page;
            this.pagination.next_url = response.data.next_page_url;
            this.pagination.first_url = response.data.first_page_url;
            this.pagination.last_url = response.data.last_page_url;
            this.pagination.previous_url = response.data.prev_page_url;
            this.pagination.from = response.data.from;
            this.pagination.to = response.data.to;
            this.pagination.total = response.data.total;
            this.filters.count = response.data.per_page;
        })
        .catch(error => console.log(error));

        axios.get('/user')
        .then((response) => {
            ;this.user = response.data;
        })
        .catch(error => console.log(error));
    },

    methods: {
        goToPage(url) {
            this.isProcessing = true;
            axios.get(url, {
                params: {
                    count: this.filters.count
                }
            })
            .then((response) => {
                this.saves = response.data.data;

                this.pagination.current = response.data.current_page;
                this.pagination.total_pages = response.data.last_page;
                this.pagination.next_url = response.data.next_page_url;
                this.pagination.previous_url = response.data.prev_page_url;
                this.pagination.from = response.data.from;
                this.pagination.to = response.data.to;
                this.pagination.total = response.data.total;
                this.pagination.per_page = response.data.per_page;

                this.isProcessing = false;

                window.scrollTo(0,0);
            })
            .catch(error => console.log(error));
        },

        filterResults(query) {
            axios.get('/saves', {
                params: {
                    query: query,
                    count: this.filters.count,
                    subreddit: this.filters.subreddit,
                    tag: this.filters.tag,
                    type: this.filters.type
                }
            })
            .then((response) => {
                this.saves = response.data.data;

                this.pagination.current = response.data.current_page;
                this.pagination.total_pages = response.data.last_page;
                this.pagination.next_url = response.data.next_page_url;
                this.pagination.first_url = response.data.first_page_url;
                this.pagination.last_url = response.data.last_page_url;
                this.pagination.previous_url = response.data.prev_page_url;
                this.pagination.from = response.data.from;
                this.pagination.to = response.data.to;
                this.pagination.total = response.data.total;
                this.pagination.per_page = response.data.per_page;
                this.filters.count = response.data.per_page;
            })
            .catch(error => console.log(error));
        },

        updateCount(count) {
            this.filters.count = count;
            this.filterResults();
        },

        updateSubreddit(subreddit) {
            this.filters.subreddit = subreddit;
            this.filterResults();
        },

        updateTag(tag) {
            this.filters.tag = tag;
            this.filterResults();
        },

        updateType(type) {
            this.filters.type = type;
            this.filterResults();
        },

        toggleFilters() {
            this.showFilters = !this.showFilters;

            if (this.showFilters) {
                axios.get('/filters')
                .then((response) => {
                    this.subreddits = response.data.subreddits;
                    this.tags = response.data.tags;
                    this.types = response.data.types;
                });
            }
        },

        clearFilters() {
            this.filters.subreddit = '';
            this.filters.tag = '';
            this.filters.type = '';
            this.filterResults();
        },

        displayErrors(errors) {
            if (this.timeout != null) {
                clearTimeout(this.timeout);
                this.timeout = null;
            }

            for (let error in errors) {
                this.errors.push({
                    'key': error, 
                    'message': errors[error][0]
                });
            }

            this.timeout = setTimeout(function() {
                this.errors = [];
            }.bind(this), 4000);
        },

        hideNav() {
            this.showNavDropdown = false;
        }
    },

    components: {
        'navigation': Navigation,
        'error-flash': ErrorFlash,
        'search': Search,
        'card': Card,
        'pagination': Pagination,
        'modal': Modal,
    }
});