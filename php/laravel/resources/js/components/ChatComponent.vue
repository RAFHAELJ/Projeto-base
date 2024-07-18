<template>
    <div class="chat-container">
        <div class="chat-messages" ref="chatMessages">
            <div v-for="message in messages" :key="message.id" class="message">
                <strong>{{ message.user.name }}:</strong> {{ message.content }}
            </div>
        </div>
        <div class="chat-input">
            <textarea v-model="newMessage" @keyup.enter="sendMessage" placeholder="Digite sua mensagem..."></textarea>
            <button @click="sendMessage">Enviar</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            messages: [],
            newMessage: ''
        };
    },
    methods: {
        sendMessage() {
            if (this.newMessage.trim() !== '') {
                const message = {
                    user: this.user,
                    content: this.newMessage,
                    id: Date.now()
                };
                this.messages.push(message);
                this.newMessage = '';

                // Emita o evento de mensagem via WebSocket
                axios.post('/send-message', message).then(response => {
                    console.log('Mensagem enviada:', response.data);
                }).catch(error => {
                    console.error('Erro ao enviar mensagem:', error);
                });
            }
        }
    },
    mounted() {
        // Escute eventos de mensagem via WebSocket
        window.Echo.channel('user.' + this.user.id)
            .listen('.SendMessage', (e) => {
                this.messages.push(e.message);
            });
    }
};
</script>

<style scoped>
.chat-container {
    position: fixed;
    bottom: 0;
    right: 0;
    width: 30%;
    height: 70%;
    border: 1px solid #ccc;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
}

.chat-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ccc;
}

.chat-input textarea {
    flex: 1;
    resize: none;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.chat-input button {
    margin-left: 10px;
    padding: 10px 15px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.chat-input button:hover {
    background-color: #218838;
}
</style>
