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
    },

    created() {
        axios.get('/saves')
        .then((response) => {
            this.saves = response.data;
        })
        .catch(error => console.log(error));

        axios.get('/user')
        .then((response) => {
            ;this.user = response.data;
        })
        .catch(error => console.log(error));
    },

    components: {
        'card': Card
    }
});