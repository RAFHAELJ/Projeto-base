




/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

// Importe o Axios e outras dependências necessárias
import axios from 'axios';


// Configuração global do Axios
axios.defaults.baseURL = 'http://php/api'; // Substitua pela URL base da sua API

// Interceptador para adicionar o token de autorização
axios.interceptors.request.use(
    function(config) {
        const token = localStorage.getItem('token'); // Supondo que o token esteja armazenado no localStorage
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    function(error) {
        return Promise.reject(error);
    }
);

// Instância do Vue.js ou outra configuração global, se necessário


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('chat-component', require('./components/ChatComponent.vue').default);

Vue.component('user-list', require('./components/UserList.vue').default);
Vue.component('chat-messenger', require('./components/ChatMessenger.vue').default);
Vue.component('ChatApp', require('./components/ChatApp.vue').default);
Vue.component('chat-notification', require('./components/ChatNotification.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        selectedUser: null
    },
    methods: {
        handleUserSelected(user) {
            this.selectedUser = user;
        }
    }
   
});
