<template>
    <div class="chat-container">
        <div class="chat-messages" ref="messages">
            <div v-for="message in messages" :key="message.id" class="chat-message">
                <strong>{{ message.user.name }}:</strong> {{ message.message }}
            </div>
        </div>
        <div class="chat-input">
            <textarea v-model="newMessage" @keyup.enter="sendMessage" placeholder="Digite sua mensagem"></textarea>
            <button @click="sendMessage">Enviar</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: '',
        };
    },
    mounted() {
        this.listenForMessages();
    },
    methods: {
        listenForMessages() {
            window.Echo.private('user.1')
                .listen('.SendMessage', (e) => {
                    this.messages.push({
                        message: e.message.message,
                        user: e.user,
                    });
                    this.scrollToEnd();
                });
        },
        sendMessage() {
            if (this.newMessage.trim() === '') return;

            axios.post('user.1', {
                message: this.newMessage
            }).then(response => {
                this.newMessage = '';
            });
        },
        scrollToEnd() {
            this.$nextTick(() => {
                const container = this.$refs.messages;
                container.scrollTop = container.scrollHeight;
            });
        }
    }
};
</script>

<style scoped>
.chat-container {
    display: flex;
    flex-direction: column;
    height: 100%;
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
}

.chat-input button {
    margin-left: 10px;
}
</style>
