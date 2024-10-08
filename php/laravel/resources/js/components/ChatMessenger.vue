<template>
    <div class="chat-messenger">
        <div class="chat-header">
            <h2>{{ selectedUser ? selectedUser.name : 'Selecione um usuário' }}</h2>
        </div>
        <div class="chat-messages">
            <div v-for="message in messages" :key="message.id" :class="messageClass(message)">
                <div class="message-container">
                    <p>{{ message.message }}</p>
                    <span class="message-time">{{ formatMessageTime(message.created_at) }}</span>
                </div>
            </div>
        </div>
        <div class="chat-input">
            <textarea ref="messageInput" v-model="newMessage" placeholder="Digite sua mensagem"></textarea>
            <button @click="sendMessage">Enviar</button>
            
        </div>
    </div>
</template>

<script>
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import moment from 'moment';
import { Picker } from 'emoji-mart-vue';
import 'emoji-mart-vue/css/emoji-mart.css';

export default {
    props: ['selectedUser'],
    components: {
        Picker
    },
    data() {
        return {
            messages: [],
            newMessage: '',
            showEmojiPicker: false,
            echo: null,
            currentUserId: null,
            activeUsers: [],
        };
    },
    watch: {
        selectedUser(newUser) {
            if (newUser && newUser.id) {
                this.fetchMessages(newUser.id);
                this.listenForMessages(newUser.id);
                this.joinChannel();
            }
        }
    },
    methods: {
        fetchMessages(userId) {
            axios.get(`/messages/${userId}`)
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        sendMessage() {
            if (this.newMessage.trim() === '') return;
            if (!this.selectedUser || !this.selectedUser.id) {
                console.error("Usuário selecionado é inválido.");
                return;
            }

            axios.post('/messages', {
                message: this.newMessage,
                destination_id: this.selectedUser.id
            })
            .then(response => {
                console.log('Mensagem enviada:', response.data); // Verifique o que está sendo enviado
                this.messages.push(response.data);
                this.$emit('messageSent', this.selectedUser.id); // Emite o evento de mensagem enviada
                this.newMessage = '';
            })
            .catch(error => {
                console.log(error);
            });
        },
        joinChannel() {
            window.Echo.join(`user.${this.currentUserId}`)
                .here((users) => {
                    this.activeUsers = users;
                })
                .joining((user) => {
                    this.activeUsers.push(user);
                })
                .leaving((user) => {
                    this.activeUsers = this.activeUsers.filter(u => u.id !== user.id);
                });
        },
        listenForMessages(userId) {
            if (this.echo) {
                this.echo.leave(`user.${this.currentUserId}`);
            }

            const token = localStorage.getItem('access_token');

            this.echo = new Echo({
                broadcaster: 'pusher',
                key: process.env.MIX_PUSHER_APP_KEY,
                cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                wsHost: window.location.hostname,
                wsPort: 6001,
                forceTLS: false,
                disableStats: true,
                enabledTransports: ['ws', 'wss'],
                auth: {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            });

            this.echo.private(`user.${this.currentUserId}`)
                .listen('.SendMessage', (e) => {
                    let messageData = JSON.parse(e.message);
                   
                    if (this.activeUsers && this.activeUsers.length > 0) {
                        let senderIsActive = this.activeUsers.some(user => user.id === messageData.sender_id);
                        
                        if (senderIsActive) {
                            this.messages.push({
                                id: messageData.destination_id,
                                message: messageData.message,
                                created_at: messageData.created_at
                            });
                            this.$emit('messageReceived', messageData.sender_id); // Emite o evento de mensagem recebida
                        } else {
                            console.log(`Mensagem recebida de usuário inativo: ${messageData.sender_id}`);
                        }
                    } else {
                        console.log('Lista de usuários ativos não está definida ou vazia.');
                    }
                });
        },
        messageClass(message) {
            return {                
                'sent-message': message.user_id === this.currentUserId,
                'received-message': message.user_id !== this.currentUserId
            };
        },
        formatMessageTime(time) {
            return moment(time).format('HH:mm');
        },
        toggleEmojiPicker() {
            this.showEmojiPicker = !this.showEmojiPicker;
        },
        addEmoji(emoji) {
            console.log('Emoji selecionado:', emoji.native); // Verifique o emoji selecionado
            this.newMessage += emoji.native;
            this.showEmojiPicker = false;
            this.$nextTick(() => {
                this.$refs.messageInput.focus();
            });
        }
    },
    mounted() {
        axios.get('/current-user')
            .then(response => {
                this.currentUserId = response.data.id;
                this.listenForMessages(this.currentUserId);
                this.joinChannel();
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>

<style scoped>
.chat-messenger {
    display: flex;
    flex-direction: column;
    height: 90%;
}

.chat-header {
    background-color: #007bff;
    color: white;
    padding: 1rem;
    text-align: center;
}

.chat-messages {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow-y: auto;
    justify-content: flex-end;
}

.sent-message {
    align-self: flex-end;
    max-width: 70%;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 10px;
    background-color: #f0f0f0;
}

.received-message {
    align-self: flex-start;
    max-width: 70%;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 10px;
    background-color: #f0f0f0;
}

.message-container {
    display: flex;
    flex-direction: column;
}

.message p {
    margin: 0;
}

.message-time {
    align-self: flex-end;
    font-size: 0.8em;
    color: #999;
}

.chat-input {
    display: flex;
    padding: 1rem;
    border-top: 1px solid #ccc;
    position: relative;
}

.chat-input textarea {
    flex: 1;
    resize: none;
    padding: 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid #ccc;
}

.chat-input button {
    margin-left: 0.5rem;
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
}

.chat-input button:hover {
    background-color: #0056b3;
}

.emoji-mart {
    position: absolute;
    bottom: 60px;
    left: 10px;
    z-index: 10;
}
</style>
