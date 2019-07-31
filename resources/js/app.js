import '@fortawesome/fontawesome-free';
import axios from 'axios';
window.axios = axios;

import Vue from 'vue';
import Navigation from './components/Nav';
import Search from './components/Search';
import Card from './components/Card';
import Pagination from './components/Pagination';
import Modal from './components/Modal';

const app = new Vue({
    el: '#app',

    data: {
        // query: '',
        saves: [],
        user: '',
        isProcessing: false,
        showFilters: false,
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
            per_page: 15,
        }
    },

    created() {
        axios.get('/saves', {
            params: {
                count: this.pagination.per_page
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
                    count: this.pagination.per_page
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
            })
            .catch(error => console.log(error));
        },

        filterResults(query) {
            axios.get('/saves', {
                params: {
                    query: query,
                    count: this.pagination.per_page
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
            })
            .catch(error => console.log(error));
        },

        updateCount(count) {
            this.pagination.per_page = count;
            this.filterResults();
        },

        toggleFilters() {
            this.showFilters = !this.showFilters;
        }
    },

    components: {
        'navigation': Navigation,
        'search': Search,
        'card': Card,
        'pagination': Pagination,
        'modal': Modal,
    }
});