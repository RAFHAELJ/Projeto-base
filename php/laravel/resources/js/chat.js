import Vue from 'vue';
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
    wsHost: php,
    wsPort: 6001,
    disableStats: true,
});

const app = new Vue({
    el: '#app',
    data: {
        messages: [],
        newMessage: ''
    },
    mounted() {
        this.listenForMessages();
    },
    methods: {
        listenForMessages() {
            window.Echo.channel('chat')
                .listen('MessageSent', (e) => {
                    this.messages.push(e.message);
                });
        },
        sendMessage() {
            axios.post('/send-message', {
                message: this.newMessage
            }).then(response => {
                console.log('Message sent!');
            }).catch(error => {
                console.error(error);
            });
            this.newMessage = '';
        }
    }
});
