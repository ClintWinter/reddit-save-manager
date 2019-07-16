import '@fortawesome/fontawesome-free';
import axios from 'axios';

import Vue from 'vue';
import Card from './components/Card';

// import { METHODS } from 'http';

class User {
    constructor() {
        this.username = '';
        this.accessToken = '';
        this.refreshToken = '';
        this.authString = '';
        this.updated_at = '';
        this.saves = [];
    }

    get(field) {
        if (this[field]) {
            return this[field];
        }
    }

    getUserData(callback) {
        axios.get('/user')
            .then(({data}) => {
                this.username = data.name;
                this.accessToken = data.access_token;
                this.refreshToken = data.refresh_token;
                this.authString = 'Bearer ' + data.access_token;
                this.updated_at = data.updated_at;

                if ( new Date() > new Date(new Date(this.updated_at).getTime() + (3600 * 1000)) ) {
                    axios.get('/refresh_token', {params: {refresh_token: this.refreshToken}})
                        .then(response => {
                            this.accessToken = response.data;
                            this.authString = 'Bearer ' + this.accessToken;
                            callback.call(this);
                        })
                        .catch(error => console.log(error));
                } else {
                    callback.call(this);
                }
            })
            .catch(error => console.log(error));
    }

    getSaves() {
        axios.get(
            `https://oauth.reddit.com/user/${this.username}/saved`,
            { 
                headers: { Authorization: this.authString },
                params: {
                    after: null,
                    before: null,
                    show: 'all',
                    count: 10,
                    username: this.username,
                    limit: 10
                }
            }
        )
        .then((response) => {
            this.saves = response.data.data.children;
        })
        .catch(error => console.log(error));
    }
}



const app = new Vue({
    el: '#app',

    data: {
        user: new User(),

    },

    created() {
        this.user.getUserData(this.user.getSaves);
    },

    components: {
        'card': Card
    }
});