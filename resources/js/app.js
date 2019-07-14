import '@fortawesome/fontawesome-free';
import axios from 'axios';

import Vue from 'vue';
import Card from './components/Card';

// import { METHODS } from 'http';




const app = new Vue({
    el: '#app',

    data: {
        user: {
            username: '',
            accessToken: '',
            authString: ''
        },
        saves: []
    },

    methods: {
        
    },

    created() {

        axios.get('/user')
        .then(({data}) => {
            this.user.username = data.name;
            this.user.accessToken = data.access_token;
            this.user.authString = 'Bearer ' + data.access_token;
        })
        .then(() => {
            axios.get(
                `https://oauth.reddit.com/user/${this.user.username}/saved`,
                { 
                    headers: { Authorization: this.user.authString },
                    params: {
                        after: null,
                        before: null,
                        show: 'all',
                        count: 10,
                        username: this.user.username,
                        limit: 10
                    }
                }
            )
            .then((response) => {
                this.saves = response.data.data.children;
                console.log(this.saves[5]);
            })
            .catch(error => console.log(error));
        })
        .catch(error => console.log(error));
    },

    components: {
        'card': Card
    }
});

// reddit api
// duration=permanent
//scope=save subreddits edit read