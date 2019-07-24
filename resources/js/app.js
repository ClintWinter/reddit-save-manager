import '@fortawesome/fontawesome-free';
import axios from 'axios';
window.axios = axios;

import Vue from 'vue';

import Card from './components/Card';

// import { METHODS } from 'http';

/**
 * TODO:
 * 
 * Hide user data behind API rather than saving it in the state... doesn't make sense.
 * 
 * No user model in JS. '/saves' should just get saves and make a model from that by getting it with guzzle using
 * the Auth::user data rather than waiting for multiple AJAX calls.
 * 
 * We can maybe put a function on the User model to check if the key needs to be refreshed?
 */



const app = new Vue({
    el: '#app',

    data: {
        saves: [],
        user: '',
        isProcessing: false,
        pagination: {
            current: null,
            total_pages: null,
            next_url: null,
            previous_url: null,
            from: null,
            to: null,
            total: null,
        }
    },

    computed: {
        prevDisabled() {
            return this.isProcessing || this.pagination.previous_url == null;
        },

        nextDisabled() {
            return this.isProcessing || this.pagination.next_url == null;
        },
    },

    created() {
        axios.get('/saves')
        .then((response) => {
            this.saves = response.data.data;

            this.pagination.current = response.data.current_page;
            this.pagination.total_pages = response.data.last_page;
            this.pagination.next_url = response.data.next_page_url;
            this.pagination.previous_url = response.data.prev_page_url;
            this.pagination.from = response.data.from;
            this.pagination.to = response.data.to;
            this.pagination.total = response.data.total;

            console.log(this.pagination.previous_url);
        })
        .catch(error => console.log(error));

        axios.get('/user')
        .then((response) => {
            ;this.user = response.data;
        })
        .catch(error => console.log(error));
    },

    methods: {
        previous() {
            this.isProcessing = true;
            axios.get(this.pagination.previous_url)
            .then((response) => {
                this.saves = response.data.data;

                this.pagination.current = response.data.current_page;
                this.pagination.total_pages = response.data.last_page;
                this.pagination.next_url = response.data.next_page_url;
                this.pagination.previous_url = response.data.prev_page_url;
                this.pagination.from = response.data.from;
                this.pagination.to = response.data.to;
                this.pagination.total = response.data.total;

                this.isProcessing = false;
            })
            .catch(error => console.log(error));
        },

        next() {
            this.isProcessing = true;

            axios.get(this.pagination.next_url)
            .then((response) => {
                this.saves = response.data.data;

                this.pagination.current = response.data.current_page;
                this.pagination.total_pages = response.data.last_page;
                this.pagination.next_url = response.data.next_page_url;
                this.pagination.previous_url = response.data.prev_page_url;
                this.pagination.from = response.data.from;
                this.pagination.to = response.data.to;
                this.pagination.total = response.data.total;

                this.isProcessing = false;
            })
            .catch(error => console.log(error));
        }
    },

    components: {
        'card': Card
    }
});